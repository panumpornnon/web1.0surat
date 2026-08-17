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

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT . '/tables');

jimport('joomla.installer.helper');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * Methods supporting a control panel
 *
 * @package    Joomla.Administrator
 * @subpackage com_coalawebtraffic
 */
class CoalawebtrafficModelManage extends JModelLegacy {
    
    /**
     * Delete (Purge) all the Traffic data from its associated tables and reset index
     * 
     * @return boolean
     */
    public function purge() {
        $deleted = 0;
        $result = true;

        $tables = array(
            '#__cwtraffic',
            '#__cwtraffic_total',
            '#__cwtraffic_whoisonline',
            '#__cwtraffic_storage',
            '#__cwtraffic_locations'
        );

        $db = $this->getDBO();
        
        while (count($tables)) {
            $table = array_shift($tables);

                // The table needs repair
                $db->setQuery('TRUNCATE TABLE ' . $db->qn($table));
                try {
                    $db->execute();
                    $deleted++;
                } catch (JDatabaseExceptionExecuting $e) {
                    return false;
                }
        }

        return $result;
    }

    /**
     * Delete (Purge) all the CoalaWeb Traffic log files
     *
     * @return array
     */
    public function purgeLogs()
    {
        $affected = [
            'test' => true,
            'deleted' => 0
        ];

        $logNames = array(
            'com_coalawebtraffic_sql.log.php',
            'com_coalawebtraffic_debug.log.php',
            'mod_cwtrafficstats.log.php',
            'plg_cwtraffic_count.log.php'
        );

        $path = JFactory::getConfig()->get('log_path');

        if (JFolder::exists($path)) {
            $archiveFiles = JFolder::files($path);

            foreach ($archiveFiles as $archive) {
                if (in_array($archive, $logNames)) {
                    try {
                        JFile::delete($path . '/' . $archive);
                        $affected['deleted']++;
                    } catch (Exception $exc) {
                        $affected['test'] = false;
                    }
                }
            }
        } else {
            $affected['test'] = false;
        }

        return $affected;
    }
}