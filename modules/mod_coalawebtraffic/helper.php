<?php
defined('_JEXEC') or die('Restricted access');
/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic Module
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

jimport('joomla.application.component.helper');
jimport('joomla.log.log');

class mod_coalawebtrafficHelper {

    /**
     * Get current counts
     *
     * @param $params
     * @return array
     */
    function read(&$params) {
        $comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $db = JFactory::getDbo();

        if ($comParams->get('log_sql')) {
            //Start our log file code
            JLog::addLogger(array('text_file' => 'com_coalawebtraffic_sql.log.php'), JLog::ERROR, 'com_coalawebtraffic_sql');
        }

        //Work out the time off set
        $config = JFactory::getConfig();
        $siteOffset = $config->get('offset');
        date_default_timezone_set($siteOffset);

        $day = date('d');
        $month = date('m');
        $year = date('Y');
        
        $daystart = mktime(0, 0, 0, $month, $day, $year);
        $monthstart = mktime(0, 0, 0, $month, 1, $year);
        $yesterdaystart = $daystart - (24 * 60 * 60);
        
        $weekDayStart = $comParams->get('week_start', 'mon');
        
        switch ($weekDayStart) {
            case 'sat':
                $weekstart = $daystart - ((date('N') + 1) * 24 * 60 * 60);
                break;
            case 'sun':
                $weekstart = $daystart - (date('N') * 24 * 60 * 60);
                break;
            case 'mon':
                $weekstart = $daystart - ((date('N') - 1) * 24 * 60 * 60);
                break;
            default:
                $weekstart = $daystart - ((date('N') - 1) * 24 * 60 * 60);
                break;
        }

        $preset = $comParams->get('preset', 0);

        //Count ongoing total
        $query = $db->getQuery(true);
        $query->select('TCOUNT');
        $query->from($db->quoteName('#__cwtraffic_total'));
        $db->setQuery($query);

        try {
            $tcount = $db->loadResult();
        } catch (Exception $e) {
            $tcount = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        // Create base to count from
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwtraffic'));
        $db->setQuery($query);

        try {
            $all_visitors = $db->loadResult();
        } catch (Exception $e) {
            $all_visitors = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        $all_visitors += $preset;
        $all_visitors += $tcount;

        //Todays Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwtraffic'));
        $query->where('tm > ' . $db->quote($daystart));
        $db->setQuery($query);

        try {
            $today_visitors = $db->loadResult();
        } catch (Exception $e) {
            $today_visitors = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        //Yesterdays Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwtraffic'));
        $query->where('tm > ' . $db->quote($yesterdaystart));
        $query->where('tm < ' . $db->quote($daystart));
        $db->setQuery($query);

        try {
            $yesterday_visitors = $db->loadResult();
        } catch (Exception $e) {
            $yesterday_visitors = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        //This Weeks Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwtraffic'));
        $query->where('tm >= ' . $db->quote($weekstart));
        $db->setQuery($query);

        try {
            $week_visitors = $db->loadResult();
        } catch (Exception $e) {
            $week_visitors = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        //Months Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwtraffic'));
        $query->where('tm >= ' . $db->quote($monthstart));
        $db->setQuery($query);

        try {
            $month_visitors = $db->loadResult();
        } catch (Exception $e) {
            $month_visitors = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFIC_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        $ret = array($all_visitors, $today_visitors, $yesterday_visitors, $week_visitors, $month_visitors);
        return ($ret);
    }

    /**
     * Who is online
     *
     * @return string
     */
    static function getRealCount() {
        $comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $db = JFactory::getDbo();

        if ($comParams->get('log_sql')) {
            //Start our log file code
            JLog::addLogger(array('text_file' => 'com_coalawebtraffic_sql.log.php'), JLog::ERROR, 'com_coalawebtraffic_sql');
        }

        //Check the Who is Online table for IPs
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->quoteName('#__cwtraffic_whoisonline'));
        $db->setQuery($query);

        try {
            $result = $db->loadResult();
        } catch (Exception $e) {
            $result = '';
            if ($comParams->get('log_sql')) {
                //Log error
                $msg = JText::sprintf('MOD_CWTRAFFICSTATS_DATABASE_ERROR', $e->getMessage());
                JLog::add($msg, JLog::ERROR, 'com_coalawebtraffic_sql');
            }
        }

        return $result;
    }

    /**
     * Create the digital counter
     *
     * @param $params
     * @param $totalNumber
     * @return string
     */
    public static function getTotalImage($params, $totalNumber) {
        $digitTheme = $params->get('digit_theme');
        $digitNumber = $params->get('digit_number');
        
        $arrNumber = mod_coalawebtrafficHelper::getArrayNumber($digitNumber, $totalNumber);

        $html = '';
        if ($arrNumber) {
            foreach ($arrNumber as $number) {
                $html .= mod_coalawebtrafficHelper::getDigitImage($number, $digitTheme);
            }
        }

        return $html;
    }

    /**
     * Create array of numbers for the counter
     *
     * @param $length
     * @param $number
     * @return array
     */
    static function getArrayNumber($length, $number) {
        $strlen = strlen($number);

        $arr = array();
        $diff = $length - $strlen;

        while ($diff > 0) {
            array_push($arr, 0);
            $diff--;
        }

        $arrNumber = str_split($number);
        $arr = array_merge($arr, $arrNumber);

        return $arr;
    }

    /**
     * Get the number images
     *
     * @param $number
     * @param $type
     * @return string
     */
    static function getDigitImage($number, $type) {
        $html = '';
        $html .= '<img class="" src="' . JURI :: base(true) . '/media/coalawebtraffic/modules/traffic/digit-themes/' . $type . '/' . $number . '.png" alt="'. $number . '.png"/>';
        return $html;
    }

}
