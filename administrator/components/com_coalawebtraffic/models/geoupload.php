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
jimport('joomla.installer.helper');

/**
 * Methods supporting a control panel
 *
 * @package    Joomla.Administrator
 * @subpackage com_coalawebtraffic
 */
class CoalawebtrafficModelGeoupload extends JModelLegacy {

    /**
     * Refresh GEO data
     *
     * @return boolean
     *
     * @since 1.1.0
     */
    public function geoRefresh()
    {
        $result = true;

        //Start our database queries
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        // Fields set to NULL
        $fields = array(
            $db->qn('country_code') . ' = NULL',
            $db->qn('country_name') . ' = NULL',
            $db->qn('city') . ' = NULL',
            $db->qn('location_latitude') . ' = NULL',
            $db->qn('location_longitude') . ' = NULL',
            $db->qn('location_time_zone') . ' = NULL',
            $db->qn('continent_code') . ' = NULL'
        );

        $query->update($db->qn('#__cwtraffic'))->set($fields);

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return false;
        }

        return $result;
    }

}