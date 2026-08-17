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


class plgSystemCwtrafficCount extends JPlugin
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
        $jlang->load('plg_system_cwtrafficcount', JPATH_ADMINISTRATOR, 'en-GB', true);
        $jlang->load('plg_system_cwtrafficcount', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
        $jlang->load('plg_system_cwtrafficcount', JPATH_ADMINISTRATOR, null, true);

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

        // Dependency checks
        if ($this->checkOk['ok'] === false) {
            if ($this->debug === '1') {
                $app->enqueueMessage($this->checkOk['msg'], $this->checkOk['type']);
            }
            return;
        }

        $comParams = JComponentHelper::getParams('com_coalawebtraffic');

        if ($app->isSite()) {

            //Lets check if our classes exist and if not display a nice graceful message
            if (
                !class_exists('CoalawebtrafficHelperIptools') ||
                !class_exists('CoalawebtrafficHelperLocation') ||
                !class_exists('CoalawebtrafficHelperDetect')) {
                if ($this->debug === '1') {
                    $app->enqueueMessage(JText::_('COM_CWTRAFFIC_MSG_MISSING'), 'error');
                }
                return;
            }

            if ($comParams->get('log_sql')) {
                //Start our log file code
                JLog::addLogger(array('text_file' => 'plg_cwtraffic_count.log.php'), JLog::ALL, 'com_coalawebtraffic');
            }

            $siteOffset = JFactory::getApplication()->getCfg('offset');
            
            // Load version.php
            $version_php = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/version.php';
            if (!defined('COM_CWTRAFFIC_VERSION') && JFile::exists($version_php)) {
                include_once $version_php;
            }

            //Let's get the visitors Browser and OS info
            $client = JFactory::getApplication()->client;

            if (!empty($client)) {
                if ($client->robot){
                    $this->browser = JText::_('COM_CWTRAFFIC_IS_ROBOT');
                    $this->bversion = JText::_('COM_CWTRAFFIC_LOCATION_UNKNOWN');
                    $platform = JText::_('COM_CWTRAFFIC_LOCATION_UNKNOWN');
                } else {
                    $this->browser = CoalawebtrafficHelperDetect::getName($client->browser);
                    $this->bversion = $client->browserVersion;
                    $platform = CoalawebtrafficHelperDetect::getName($client->platform);
                }
            } else {
                $this->browser = JText::_('COM_CWTRAFFIC_LOCATION_UNKNOWN');
                $this->bversion = JText::_('COM_CWTRAFFIC_LOCATION_UNKNOWN');
                $platform = JText::_('COM_CWTRAFFIC_LOCATION_UNKNOWN');
            }

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "") {
                $referer = $_SERVER['HTTP_REFERER'];
            } else {
                $referer = JText::_('COM_CWTRAFFIC_UNKNOWN');
            }

            //Current date time
            $dtnow = JFactory::getDate('now', $siteOffset);
            $now = $dtnow->toUnix(true);

            //How long should an IP be locked for.
            $locktime = $comParams->get('locktime', 60) * 60;

            //Get the users IP
            $this->ip = CoalawebtrafficHelperIptools::getUserIp();

            //Start our database queries
            $db = JFactory::getDbo();

            //Check the Knownips table for IPs that are published and shouldn't be counted
            $query = $db->getQuery(true);
            $query->select('ip');
            $query->from($db->qn('#__cwtraffic_knownips'));
            $query->where('state = 1 AND count = 0');
            $db->setQuery($query);
            
            try {
                $ipTable = $db->loadColumn();
            } catch (Exception $e) {
                $ipTable = '';
                if ($comParams->get('log_sql')) {
                    //Log error
                    $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                    JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                }
            }

            //Check the Known Ips returned from above against current user IP
            $iplock = 0;
            if (!empty($ipTable)) {
                if (class_exists('CoalawebtrafficHelperIptools')) {
                    $iplock = CoalawebtrafficHelperIptools::ipinList($this->ip, $ipTable);
                }
            } else {
                $iplock = 0;
            }

            //Check the Knownips table for Bots that are published and shouldn't be counted
            $query = $db->getQuery(true);
            $query->select('botname');
            $query->from($db->qn('#__cwtraffic_knownips'));
            $query->where('state = 1 AND count = 0');
            $db->setQuery($query);
            
            try {
                $botTable = $db->loadColumn();
            } catch (Exception $e) {
                $botTable = '';
                if ($comParams->get('log_sql')) {
                    //Log error
                    $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                    JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                }
            }
            
            if ($client->userAgent) {
                $agent = $client->userAgent;
            } else {
                $agent = '';
            }

            $bot = 0;
            
            if (!empty($agent) && !empty($botTable)) {
                foreach ($botTable as $bot_value) {
                    if (!empty($bot_value)) {
                        if (preg_match('/' . $bot_value . '/i', trim($agent))) {
                            $bot = 1;
                            break;
                        }
                    }
                }
            }
            
            //Check for bot using JApplicationWebClient
            if (!empty($client) && $comParams->get('basic_bots', 0)) {
                if ($client->robot){
                    $bot = 1;
                }
            }
           

            //Check with Project Honeypot
            if ($comParams->get('honeypot')) {
                $hp = self::checkHoneypot($this->ip);
            } else {
                $hp = false;
            }

            $storeRaw = $comParams->get('store_raw', 1);
            $storeLocation = $comParams->get('store_location', 1);
            
            // Check if IP already exists and reload lock expired
            $query = $db->getQuery(true);
            $query->select('count(*)');
            $query->from($db->qn('#__cwtraffic'));
            $query->where('iphash = UNHEX(SHA1(' . $db->q($this->ip) . '))');
            $query->where('tm + ' . $db->q($locktime) . '>' . $db->q($now));
            $db->setQuery($query);
            
            try {
                $items = $db->loadResult();
            } catch (Exception $e) {
                $items = '';
                if ($comParams->get('log_sql')) {
                    //Log error
                    $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                    JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                }
            }

            // If all is good lets count the visitor.
            if (empty($items) AND $bot == 0 AND $iplock == 0 AND $hp == false) {
                
                //Lets get some GEO info on our IP
                if ($storeLocation) {
                    if (CoalawebtrafficHelperLocation::geodatExist()) {
                        $details = CoalawebtrafficHelperLocation::geoInfo($this->ip);
                            $countryCode = $details['country_code'];
                            $countryName = $details['country_name'];
                            $city = $details['city'];
                            $location_latitude = NULL;
                            $location_longitude = NULL;
                            $location_time_zone = NULL;
                            $continent_code = NULL;
                        } else {
                            $countryCode = NULL;
                            $countryName = NULL;
                            $city = NULL;
                            $location_latitude = NULL;
                            $location_longitude = NULL;
                            $location_time_zone = NULL;
                            $continent_code = NULL;
                        }

                } else {
                    $countryCode = NULL;
                    $countryName = NULL;
                    $city = NULL;
                    $location_latitude = NULL;
                    $location_longitude = NULL;
                    $location_time_zone = NULL;
                    $continent_code = NULL;
                }

                $query = $db->getQuery(true);
                $query->insert($db->qn('#__cwtraffic'));

                if ($storeRaw){
                    $query->columns('tm, ip, iphash, browser, bversion, platform, referer, country_code, country_name, city, location_latitude, location_longitude, location_time_zone, continent_code');
                    $query->values($db->q($now) . ',' . $db->q($this->ip) . ', UNHEX(SHA1(' . $db->q($this->ip) . ')),' . $db->q($this->browser) . ',' . $db->q($this->bversion) . ',' . $db->q($platform) . ',' . $db->q($referer) . ',' . $db->q($countryCode) . ',' . $db->q($countryName) . ',' . $db->q($city) . ',' . $db->q($location_latitude) . ',' . $db->q($location_longitude) . ',' . $db->q($location_time_zone) . ',' . $db->q($continent_code));
                } else {
                    $query->columns('tm, iphash, browser, bversion, platform, referer, country_code, country_name, city, location_latitude, location_longitude, location_time_zone, continent_code');
                    $query->values($db->q($now) . ', UNHEX(SHA1(' . $db->q($this->ip) . ')),' . $db->q($this->browser) . ',' . $db->q($this->bversion) . ',' . $db->q($platform) . ',' . $db->q($referer) . ',' . $db->q($countryCode) . ',' . $db->q($countryName) . ',' . $db->q($city) . ',' . $db->q($location_latitude) . ',' . $db->q($location_longitude) . ',' . $db->q($location_time_zone) . ',' . $db->q($continent_code));
                }

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

            // Update location info for our visitors
            if ($storeLocation) {
                if (CoalawebtrafficHelperLocation::geodatExist()) {
                    CoalawebtrafficHelperLocation::location_updatev2();
                }
            }
            
            return $query;
        }
    }

    /**
     * Check IP against Honeypot
     *
     * @param $reqip
     * @return bool|void
     */
    private function checkHoneypot($reqip)
    {
        $comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $honeypotKey = $comParams->get('honeypot_key');
        $minThreat = $comParams->get('honeypot_min');
        $maxAge = $comParams->get('honeypot_max');
        $suspicious = $comParams->get('honeypot_sus');
        $searchEng = $comParams->get('honeypot_seng');
        $block = false;

        // Make sure we have an HTTP:BL  key set
        if (empty($honeypotKey)) {
            return;
        }

        // Get the IP address
        if ($reqip == '0.0.0.0') {
            return false;
        }

        if (strpos($reqip, '::') === 0) {
            $reqip = substr($reqip, strrpos($reqip, ':') + 1);
        }

        // No point continuing if we can't get an address, right?
        if (empty($reqip)) {
            return false;
        }

        // IPv6 addresses are not supported by HTTP:BL yet
        if (strpos($reqip, ":")) {
            return false;
        }

        $lookup = $honeypotKey . '.' . implode('.', array_reverse(explode ('.', $reqip ))) . '.dnsbl.httpbl.org';
        $result = explode( '.', gethostbyname($lookup));
        
        if (!empty($result)) {
            return false;
        }
        
        if ($result[0] != 127) {
            return; // Make sure it's a valid response
        }
        
        if (($suspicious && ($result[3] == 1)) || ($result[3] >= 2)) {
            $block = true; //Is supicious or block if requested next block anything with 2 or above. 
        }

        $block = $block && ($result[1] <= $maxAge); //Check age against extension options
        $block = $block && ($result[2] >= $minThreat); //Check max threat against extension options.

        if ($searchEng && $result[3] == 0) {
            $block = true; //If requested block search engine regardless of max age and min threat.
        }
        
        return $block;
    }

    /**
     * Check dependencies
     *
     * @return array
     */
    private function checkDependencies()
    {

        $langRoot = 'PLG_CWTRAFFICCOUNT';

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
            'files' => array(),
            'folders' => array()
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
            'modules' => array(),
            'plugins' => array()
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