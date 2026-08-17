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
JLoader::import('joomla.html.parameter');
JLoader::import('joomla.application.component.helper');

//Helpers
$path = '/components/com_coalawebtraffic/helpers/';
JLoader::register('CoalawebtrafficHelper', JPATH_ADMINISTRATOR . $path . 'coalawebtraffic.php');

//Version
$version_php = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/version.php';
if (!defined('COM_CWTRAFFIC_VERSION') && JFile::exists($version_php)) {
    include_once $version_php;
}

class plgSystemCwtrafficClean extends JPlugin {

    private $checkOk;
    private $debug;
    private $comParams;

    /**
     * Constructor
     *
     * @param   object $subject The object to observe
     * @param   array $config An array that holds the plugin configuration
     */
    public function __construct(&$subject, $config) {
        parent::__construct($subject, $config);

        // Load the language files
        $jlang = JFactory::getLanguage();

        // Plugin
        $jlang->load('plg_system_cwtrafficclean', JPATH_ADMINISTRATOR, 'en-GB', true);
        $jlang->load('plg_system_cwtrafficclean', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
        $jlang->load('plg_system_cwtrafficclean', JPATH_ADMINISTRATOR, null, true);

        // Component
        $jlang->load('com_coalawebtraffic', JPATH_ADMINISTRATOR, 'en-GB', true);
        $jlang->load('com_coalawebtraffic', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
        $jlang->load('com_coalawebtraffic', JPATH_ADMINISTRATOR, null, true);

        $this->checkOk = $this->checkDependencies();
        $this->comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $this->debug = null !== $this->params->get('debug') ? $this->params->get('debug') : $this->comParams->get('debug', '0');
    }

    public function onAfterRoute() {

        $app = JFactory::getApplication();

        // Dependency checks
        if ($this->checkOk['ok'] === false) {
            if ($this->debug === '1') {
                $app->enqueueMessage($this->checkOk['msg'], $this->checkOk['type']);
            }
            return;
        }

        $comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $dbClean = $comParams->get('db_clean');
        $duplicateClean = $comParams->get('duplicate_clean');
        $dbKeep = $comParams->get('db_keep', '1');
        $storeRaw = $comParams->get('store_raw', '1');
        $logSize = $comParams->get('log_size', 1000000);

        if ($app->isSite()) {

            if (class_exists('CoalawebtrafficHelper')) {
                $logFiles = array(
                    'com_coalawebtraffic_sql.log.php',
                    'com_coalawebtraffic_debug.log.php',
                    'mod_cwtrafficstats.log.php',
                    'plg_cwtraffic_count.log.php'
                );
                CoalawebtrafficHelper::purgeLogsSize($logFiles, $logSize);
            }

            if ($comParams->get('log_sql')) {
                //Start our log file code
                JLog::addLogger(array('text_file' => 'com_coalawebtraffic_sql.log.php'), JLog::ERROR, 'com_coalawebtraffic_sql');
            }

            $db = JFactory::getDbo();

            //Let check the lock time
            $locktime = $comParams->get('locktime', 60) * 60;

            if ($locktime > 0 && $duplicateClean) {
                //Lets get rid of duplicates with in 10 seconds of each other (Probably Bots!)
                //We will do it in 50 record chunks to keep the queries fast.compar
                $query = $db->getQuery(true);
                if($storeRaw){
                    $query
                        ->select('id, LEFT( tm, 9 ) , ip, count(*)')
                        ->from($db->qn('#__cwtraffic'))
                        ->group('LEFT( tm, 9 ) , ip')
                        ->having('count(*) > 1');
                } else {
                $query
                    ->select('id, LEFT( tm, 9 ) , HEX(iphash), count(*)')
                    ->from($db->qn('#__cwtraffic'))
                    ->group('LEFT( tm, 9 ) , HEX(iphash)')
                    ->having('count(*) > 1');
                }
                              
                try {
                    $db->setQuery($query, 0, 50);
                    $dups = $db->loadObjectList();
                } catch (JDatabaseExceptionExecuting $e) {
                    $dups = '';
                    if ($comParams->get('log_sql')) {
                        //Log error
                        $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                        JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                    }
                }

                //If we have some lets delete them and only leave 1
                if ($dups) {
                    foreach ($dups as $row) {
                        $query = $db->getQuery(true);
                        $query->from($db->qn('#__cwtraffic'));
                        $query->delete();
                        $query->where('id = ' . $db->q($row->id));

                        try {
                            $db->setQuery($query);
                            $db->execute();
                        } catch (JDatabaseExceptionExecuting $e) {
                            if ($comParams->get('log_sql')) {
                                //Log error
                                $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                            }
                        }
                    }
                }
            }

            $saveReports = $comParams->get('save_reports', '');
            if ($saveReports) {
                $config = JFactory::getConfig();
                $siteOffset = $config->get('offset');
                date_default_timezone_set($siteOffset);
                $base_date = date('Y-m-d');

                // Is today last day of month
                if(gmdate('t') == gmdate('d')){
                    echo 'Last day of the month.';
                }

                if(date("w") == 0){
                    //Sunday
                }

                // Monthly saved on the last day of the month
                $date = new DateTime($base_date);
                //First day of month
                $date->modify('first day of this month');
                $from = $date->format('Y-m-d');
                //Last day of month
                $date->modify('last day of this month');
                $to = $date->format('Y-m-d');

                if($base_date == $to) {
                    $inputs = array(
                        'from' => $from,
                        'to' => $to
                    );

                    // Load the Joomla Model framework
                    jimport('joomla.application.component.model');

                    // Load com_coalawebtraffic Visitors model.
                    // Remember the file name should be visitors.php inside the models folder
                    JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/models', 'Visitors');

                    //Get Instance of Model Object
                    $visitorsInstance = JModelLegacy::getInstance('Visitors', 'CoalawebtrafficModel');

                    //Now you can call the methods inside the model
                    // Populate our data based on dates
                    $data = $visitorsInstance->saveReport($inputs);
                }

            }

            if ($dbClean) {

                //Prepare Total table
                $query = $db->getQuery(true);
                $query->select('TCOUNT');
                $query->from($db->qn('#__cwtraffic_total'));
                
                try {
                    $db->setQuery($query);
                    $currenttotal = $db->loadResult();
                } catch (JDatabaseExceptionExecuting $e) {
                    $currenttotal = '';
                    if ($comParams->get('log_sql')) {
                        //Log error
                        $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                        JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                    }
                }

                if (empty($currenttotal)) {
                    $query = $db->getQuery(true);

                    $columns = array('tcount');
                    $values = array(0);

                    $query
                            ->insert($db->qn('#__cwtraffic_total'))
                            ->columns($db->qn($columns))
                            ->values(implode(',', $values));

                    try {
                        $db->setQuery($query);
                        $db->execute();
                    } catch (JDatabaseExceptionExecuting $e) {
                        if ($comParams->get('log_sql')) {
                            //Log error
                            $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                            JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                        }
                    }
                }

                $config = JFactory::getConfig();
                $siteOffset = $config->get('offset');
                date_default_timezone_set($siteOffset);

                $month = date('m');
                $year = date('Y');

                //Calculate the start of the month
                $monthstart = mktime(0, 0, 0, $month, 1, $year);

                switch ($dbKeep) {
                    case 1:
                        $cleanstart = strtotime("-1 week", $monthstart);
                        break;
                    case 2:
                        $cleanstart = strtotime("-3 months", $monthstart);
                        break;
                    case 3:
                        $cleanstart = strtotime("-6 months", $monthstart);
                        break;
                    case 4:
                        $cleanstart = strtotime("-12 months", $monthstart);
                        break;
                    default:
                        $cleanstart = strtotime("-1 week", $monthstart);
                        break;
                }

                $query = $db->getQuery(true);
                $query->select('count(*)');
                $query->from($db->qn('#__cwtraffic'));
                $query->where('tm < ' . $db->q($cleanstart));

                try {
                    $db->setQuery($query);
                    $oldrows = $db->loadResult();
                } catch (JDatabaseExceptionExecuting $e) {
                    $oldrows = '';
                    if ($comParams->get('log_sql')) {
                        //Log error
                        $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                        JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                    }
                }

                if (!empty($oldrows)) {
                    $query = $db->getQuery(true);
                    $query->update($db->qn('#__cwtraffic_total'));
                    $query->set('tcount = tcount +' . $db->q($oldrows));
                    
                    try {
                        $db->setQuery($query);
                        $db->execute();
                    } catch (JDatabaseExceptionExecuting $e) {
                        if ($comParams->get('log_sql')) {
                            //Log error
                            $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                            JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                        }
                        //return before deleting
                        return false;
                    }

                    $query = $db->getQuery(true);
                    $query->from($db->qn('#__cwtraffic'));
                    $query->delete();
                    $query->where('tm < ' . $db->q($cleanstart));
                    
                    try {
                        $db->setQuery($query);
                        $db->execute();
                    } catch (JDatabaseExceptionExecuting $e) {
                        if ($comParams->get('log_sql')) {
                            //Log error
                            $msg = JText::sprintf('COM_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                            JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
                        }
                        return false;
                    }
                }

                return;
            }
        }
        return;
    }

    /**
     * Check dependencies
     *
     * @return array
     */
    private function checkDependencies()
    {

        $langRoot = 'PLG_CWTRAFFICCLEAN';

        /**
         * Gears dependencies
         */
        $version = (COM_CWTRAFFIC_MIN_GEARS_VERSION); // Minimum version

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