<?php
defined('_JEXEC') or die('Restricted access');
/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2020 Steven Palmer All rights reserved.
 *
 * CoalaWeb Traffic is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

JLoader::import('joomla.plugin.plugin');
JLoader::import('joomla.application.plugin');
JLoader::import('joomla.log.log');
JLoader::import('joomla.filesystem.path');
JLoader::import('joomla.filesystem.file');
JLoader::import('joomla.html.parameter');
JLoader::import('joomla.application.component.helper');

//Helpers
$path = '/components/com_coalawebtraffic/helpers/';
JLoader::register('CoalawebtrafficHelperIptools', JPATH_ADMINISTRATOR . $path . 'iptools.php');
JLoader::register('CoalawebtrafficHelperLocation', JPATH_ADMINISTRATOR . $path . 'location.php');
JLoader::register('CoalawebtrafficHelperDetect', JPATH_ADMINISTRATOR . $path . 'detect.php');

class plgSystemCwtrafficOnline extends JPlugin
{
    private $checkOk;
    private $debug;
    private $comParams;

    /**
     * Constructor
     *
     * @param   object $subject The object to observe
     * @param   array $config An array that holds the plugin configuration
     */
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

        // Load the language files
        $jlang = JFactory::getLanguage();

        // Plugin
        $jlang->load('plg_system_cwtrafficonline', JPATH_ADMINISTRATOR, 'en-GB', true);
        $jlang->load('plg_system_cwtrafficonline', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
        $jlang->load('plg_system_cwtrafficonline', JPATH_ADMINISTRATOR, null, true);

        // Component
        $jlang->load('com_coalawebtraffic', JPATH_ADMINISTRATOR, 'en-GB', true);
        $jlang->load('com_coalawebtraffic', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
        $jlang->load('com_coalawebtraffic', JPATH_ADMINISTRATOR, null, true);

        $this->checkOk = $this->checkDependencies();
        $this->comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $this->debug = null !== $this->params->get('debug') ? $this->params->get('debug') : $this->comParams->get('debug', '0');
    }

    public function onAfterRoute()
    {
        $app = JFactory::getApplication();
        $client = JFactory::getApplication()->client;

        if ($client->robot || $app->getName() !== 'site') {
            return;
        }

        // Dependency checks
        if ($this->checkOk['ok'] === false) {
            if ($this->debug === '1') {
                $app->enqueueMessage($this->checkOk['msg'], $this->checkOk['type']);
            }
            return;
        }

        $db = JFactory::getDbo();
        $comParams = JComponentHelper::getParams('com_coalawebtraffic');

        // Should we store a cookie? If not remove old cookie, clear DB and then return
        if (!$comParams->get('set_cookie', 1)){
            if (isset($_COOKIE['cwGeoData'])) {
                unset($_COOKIE['cwGeoData']);
                setcookie('cwGeoData', '', time() - 3600, '/'); // empty value and old timestamp
            }
            $db->setQuery('TRUNCATE TABLE ' . $db->qn('#__cwtraffic_whoisonline'));
            try {
                $db->execute();
            } catch (Exception $exc) {
            }
            return;
        }

        //Lets check if our classes exist and if not display a nice graceful message
        if (
            !class_exists('CoalawebtrafficHelperIptools') ||
            !class_exists('CoalawebtrafficHelperLocation') ||
            !class_exists('CoalawebtrafficHelperDetect')
        ) {
            if ($this->debug === '1') {
                $app->enqueueMessage(JText::_('COM_CWTRAFFIC_MSG_MISSING'), 'error');
            }
            return;
        }

        if ($comParams->get('log_sql')) {
            //Start our log file code
            JLog::addLogger(array('text_file' => 'com_coalawebtraffic_sql.log.php'), JLog::ERROR, 'com_coalawebtraffic_sql');
        }

        // Load version.php
        $version_php = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/version.php';
        if (!defined('COM_CWTRAFFIC_VERSION') && JFile::exists($version_php)) {
            include_once $version_php;
        }

        //Get the users IP
        $stringIp = CoalawebtrafficHelperIptools::getUserIp();
        $intIp = ip2long($stringIp);

        //Check the Who is Online table for IPs
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->qn('#__cwtraffic_whoisonline'));
        $query->where('iphash = UNHEX(SHA1(' . $db->q($intIp) . ')) OR ip = ' . $db->q($intIp));
        $db->setQuery($query);

        try {
            $inDB = $db->loadResult();
        } catch (Exception $e) {
            $inDB = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        if (!$inDB) {
            if (isset($_COOKIE['cwGeoData'])) {
                $cookie = $_COOKIE['cwGeoData'];
            }

            if (!empty($cookie)) {
                // A "geoData" cookie has been previously set by the script, so we will use it
                // Always escape any user input, including cookies:
                list($city, $countryName, $countryCode) = explode('|', strip_tags($cookie));
            } else {

                //Lets get some info on our IP
                if (CoalawebtrafficHelperLocation::geodatExist()) {
                    $details = CoalawebtrafficHelperLocation::geoInfo($stringIp);
                }

                $city = !empty($details['city']) ? $details['city'] : "unknown city";
                $countryName = !empty($details['country_name']) ? $details['country_name'] : "unknown country";
                $countryCode = !empty($details['country_code']) ? $details['country_code'] : "xx";

                // Setting a cookie with the data, which is set to expire in a month:
                setcookie('cwGeoData', $city . '|' . $countryName . '|' . $countryCode, time() + 60 * 60 * 24 * 30, '/');
            }

            $query = $db->getQuery(true);
            $query->insert($db->qn('#__cwtraffic_whoisonline'));

            $query->columns('ip, country_name, country_code, city,  dt');
            $query->values($db->q($intIp) . ', ' . $db->q($countryName) . ',' . $db->q($countryCode) . ',' . $db->q($city) . ',NOW()');

            $db->setQuery($query);

            try {
                $db->execute();
            } catch (Exception $e) {
                if ($comParams->get('log_sql')) {
                    //Log error
                    $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                    JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                }
            }
        } else {
            // If the visitor is already online, just update the dt value of the row:
            $query = $db->getQuery(true);
            $query->update($db->qn('#__cwtraffic_whoisonline'));
            $query->set('dt = NOW()');
            $query->where('iphash = UNHEX(SHA1(' . $db->q($intIp) . ')) OR ip = ' . $db->q($intIp));
            $db->setQuery($query);

            try {
                $db->execute();
            } catch (Exception $e) {
                if ($comParams->get('log_sql')) {
                    //Log error
                    $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                    JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                }
            }
        }
        $query = $db->getQuery(true);
        $query->delete($db->qn('#__cwtraffic_whoisonline'));
        $query->where("dt < SUBTIME(NOW(),'0 0:10:0')");
        $db->setQuery($query);

        try {
            $db->execute();
        } catch (Exception $e) {
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }
    }

    /**
     * Check dependencies
     *
     * @return array
     */
    private function checkDependencies()
    {

        $langRoot = 'PLG_CWTRAFFICONLINE';

        /**
         * Gears dependencies
         */
        $version = '0.4.9'; // Minimum version

        // Classes that are needed
        $assets = [
            'mobile' => false, // Mobile detect library
            'count' => false, // Check gear DB for current URL asset count
            'tools' => true, // General tool methods (always true)
            'latest' => false // Compare currently installed to latest version
        ];

        // Check if Gears dependencies are meet and return result
        $results = self::checkGears($version, $assets, $langRoot);

        if ($results['ok'] == false) {
            $result = [
                'ok' => $results['ok'],
                'type' => $results['type'],
                'msg' => $results['msg']
            ];

            return $result;
        }


        // Lets use our tools class from Gears
        $tools = new CwGearsHelperTools();

        /**
         * File and folder dependencies
         * Note: JPATH_ROOT . '/' prefix will be added to file and folder names
         */
        $filesAndFolders = array(
            'files' => array(
            ),
            'folders' => array(
            )
        );

        // Check if they are available
        $exists = $tools::checkFilesAndFolders($filesAndFolders, $langRoot);

        // If any of the file/folder dependencies fail return
        if ($exists['ok'] == false) {
            $result = [
                'ok' => $exists['ok'],
                'type' => $exists['type'],
                'msg' => $exists['msg']
            ];

            return $result;
        }

        /**
         * Extension Dependencies
         * Note: Plugins always need to be entered in the following format plg_type_name
         */
        $extensions = array(
            'components' => array(
                'com_coalawebtraffic'
            ),
            'modules' => array(
            ),
            'plugins' => array(
            )
        );

        // Check if they are available
        $extExists = $tools::checkExtensions($extensions, $langRoot);

        // If any of the extension dependencies fail return
        if ($extExists['ok'] == false) {
            $result = [
                'ok' => $extExists['ok'],
                'type' => $extExists['type'],
                'msg' => $extExists['msg']
            ];

            return $result;
        }

        // No problems? return all good
        $result = ['ok' => true];

        return $result;
    }

    /**
     * Check Gears dependencies
     *
     * @param $version - minimum version
     * @param array $assets - list of required assets
     * @param $langRoot
     * @return array
     */
    private function checkGears($version, $assets = array(), $langRoot)
    {
        jimport('joomla.filesystem.file');

        // Load the version.php file for the CW Gears plugin
        $version_php = JPATH_SITE . '/plugins/system/cwgears/version.php';
        if (!defined('PLG_CWGEARS_VERSION') && JFile::exists($version_php)) {
            include_once $version_php;
        }

        // Is Gears installed and the right version and published?
        if (
            JPluginHelper::isEnabled('system', 'cwgears') &&
            JFile::exists($version_php) &&
            version_compare(PLG_CWGEARS_VERSION, $version, 'ge')
        ) {
            // Base helper directory
            $helperDir = JPATH_SITE . '/plugins/system/cwgears/helpers/';

            // Do we need the mobile detect class?
            if ($assets['mobile'] == true && !class_exists('Cwmobiledetect')) {
                $mobiledetect_php = $helperDir . 'cwmobiledetect.php';
                if (JFile::exists($mobiledetect_php)) {
                    JLoader::register('Cwmobiledetect', $mobiledetect_php);
                } else {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::_($langRoot . '_NOGEARSPLUGIN_HELPER_MESSAGE')
                    ];
                    return $result;
                }
            }

            // Do we need the load count class?
            if ($assets['count'] == true && !class_exists('CwGearsHelperLoadcount')) {
                $loadcount_php = $helperDir . 'loadcount.php';
                if (JFile::exists($loadcount_php)) {
                    JLoader::register('CwGearsHelperLoadcount', $loadcount_php);
                } else {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::_($langRoot . '_NOGEARSPLUGIN_HELPER_MESSAGE')
                    ];
                    return $result;
                }
            }

            // Do we need the tools class?
            if ($assets['tools'] == true && !class_exists('CwGearsHelperTools')) {
                $tools_php = $helperDir . 'tools.php';
                if (JFile::exists($tools_php)) {
                    JLoader::register('CwGearsHelperTools', $tools_php);
                } else {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::_($langRoot . '_NOGEARSPLUGIN_HELPER_MESSAGE')
                    ];
                    return $result;
                }
            }

            // Do we need the latest class?
            if ($assets['latest'] == true && !class_exists('CwGearsLatestversion')) {
                $latest_php = $helperDir . 'latestversion.php';
                if (JFile::exists($latest_php)) {
                    JLoader::register('CwGearsLatestversion', $latest_php);
                } else {
                    $result = [
                        'ok' => false,
                        'type' => 'warning',
                        'msg' => JText::_($langRoot . '_NOGEARSPLUGIN_HELPER_MESSAGE')
                    ];
                    return $result;
                }
            }
        } else {
            // Looks like Gears isn't meeting the requirements
            $result = [
                'ok' => false,
                'type' => 'warning',
                'msg' => JText::sprintf($langRoot . '_NOGEARSPLUGIN_CHECK_MESSAGE', $version)
            ];
            return $result;
        }

        // Set up our response array
        $result = [
            'ok' => true,
            'type' => '',
            'msg' => ''
        ];

        // Return our result
        return $result;

    }
}
