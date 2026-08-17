<?php

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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 *  CoalaWeb Traffic component helper.
 */
class CoalawebtrafficHelper
{

    /**
     * Configure the Linkbar.
     *
     * @param string $vName The name of the active view.
     *
     * @return void
     */
    public static function addSubmenu($vName = 'controlpanel') 
    {
        // Load version.php
        $version_php = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/version.php';
        if (!defined('COM_CWTRAFFIC_VERSION') && JFile::exists($version_php)) {
            include_once $version_php;
        }

        JHtmlSidebar::addEntry(
            JText::_('COM_CWTRAFFIC_TITLE_CPANEL'), 'index.php?option=com_coalawebtraffic&view=controlpanel', $vName == 'controlpanel'
        );
        JHtmlSidebar::addEntry(
            JText::_('COM_CWTRAFFIC_TITLE_VISITORS'), 'index.php?option=com_coalawebtraffic&view=visitors', $vName == 'visitors'
        );
        if (COM_CWTRAFFIC_PRO == 1){
            JHtmlSidebar::addEntry(
                JText::_('COM_CWTRAFFIC_TITLE_LOCATIONS'), 'index.php?option=com_coalawebtraffic&view=locations', $vName == 'locations'
            );
        }
        JHtmlSidebar::addEntry(
            JText::_('COM_CWTRAFFIC_TITLE_IPCATS'), 'index.php?option=com_categories&extension=com_coalawebtraffic', $vName == 'categories'
        );
        JHtmlSidebar::addEntry(
            JText::_('COM_CWTRAFFIC_TITLE_KNOWNIPS'), 'index.php?option=com_coalawebtraffic&view=knownips', $vName == 'knownips'
        );
        JHtmlSidebar::addEntry(
            JText::_('COM_CWTRAFFIC_TITLE_GEO'), 'index.php?option=com_coalawebtraffic&view=geoupload', $vName == 'geoupload'
        );
        if (COM_CWTRAFFIC_PRO == 1){
            JHtmlSidebar::addEntry(
                JText::_('COM_CWTRAFFIC_TITLE_CHARTS'), 'index.php?option=com_coalawebtraffic&view=charts', $vName == 'charts'
            );
        }

        JHtmlSidebar::addEntry(
            JText::_('COM_CWTRAFFIC_TITLE_MANAGE'), 'index.php?option=com_coalawebtraffic&view=manage', $vName == 'manage'
        );
        
    }

    /**
     * Delete log files based on modified age
     *
     * @param $files
     * @param int $maxAge
     */
    public static function purgeLogsAge($files, $maxAge = 7)
    {
        $path = JFactory::getConfig()->get('log_path');

        $now = time();

        $threshold = $maxAge * 24 * 3600;

        if (
            JFolder::exists($path)) {
            $archiveFiles = JFolder::files($path);

            foreach ($archiveFiles as $archive) {
                if (in_array($archive, $files)) {

                    //Get modified time
                    $modTime = @filemtime($path . '/' . $archive);

                    if (($now - $modTime) > $threshold) {
                        try {
                            JFile::delete($path . '/' . $archive);
                        } catch (Exception $exc) {
                            //nothing
                        }
                    }
                }
            }
        }
    }

    /**
     * Delete log files based on size
     *
     * @param $files
     * @param int $maxSize
     */
    public static function purgeLogsSize($files, $maxSize = 1000000)
    {
        $path = JFactory::getConfig()->get('log_path');

        if (JFolder::exists($path)) {
            $archiveFiles = JFolder::files($path);

            foreach ($archiveFiles as $archive) {
                if (in_array($archive, $files)) {
                    if (@filesize($path . '/' . $archive) > $maxSize) {
                        try {
                            JFile::delete($path . '/' . $archive);
                        } catch (Exception $exc) {
                            //nothing
                        }
                    }
                }
            }
        }
    }

    /**
     * Check dependencies
     *
     * @return array
     */
    public static function checkDependencies() {

        $langRoot = 'COM_CWTRAFFIC';

        /**
         * Gears dependencies
         */
        $version = '0.4.8'; // Minimum version

        // Classes that are needed
        $assets = [
            'mobile' => false,
            'count' => true,
            'tools' => true,
            'latest' => true
        ];

        // Check if Gears dependencies are meet and return result
        $results = self::checkGears($version, $assets, $langRoot);

        if($results['ok'] == false){
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
        if($exists['ok'] == false){
            $result = [
                'ok' => $exists['ok'],
                'type' => $exists['type'],
                'msg' => $exists['msg']
            ];

            return $result;
        }

        /**
         * Extension Dependencies
         */
        $extensions = array(
            'components' => array(
            ),
            'modules' => array(
            ),
            'plugins' => array(
            )
        );

        // Check if they are available
        $extExists = $tools::checkExtensions($extensions, $langRoot);

        // If any of the extension dependencies fail return
        if($extExists['ok'] == false){
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
    public static function checkGears($version, $assets = array(), $langRoot)
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
                        'type' => 'notice',
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
                        'type' => 'notice',
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
                        'type' => 'notice',
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
                        'type' => 'notice',
                        'msg' => JText::_($langRoot . '_NOGEARSPLUGIN_HELPER_MESSAGE')
                    ];
                    return $result;
                }
            }
        } else {
            // Looks like Gears isn't meeting the requirements
            $result = [
                'ok' => false,
                'type' => 'notice',
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