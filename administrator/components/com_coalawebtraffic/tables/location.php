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

use Joomla\Utilities\ArrayHelper;

/**
 * Client table
 *
 * @since  1.6
 */
class CoalawebtrafficTableLocation extends JTable
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  Database connector object
     *
     * @since   1.5
     */
    public function __construct(&$db)
    {
        $this->checked_out_time = $db->getNullDate();
        parent::__construct('#__cwtraffic_locations', 'id', $db);

        JTableObserverContenthistory::createObserver($this, array('typeAlias' => 'com_coalawebtraffic.location'));
    }

    /**
     * Overloaded check method to ensure data integrity.
     *
     * @return  boolean  True on success.
     */
    public function check()
    {
        // Check for valid city.
        if ($this->type == 1 && trim($this->country_code) == '')
        {
            $this->setError(JText::_('COM_CWTRAFFIC_ERROR_VALID_COUNTRY'));
            return false;
        }

        // Check for valid city.
        if ($this->type == 2 && trim($this->city) == '')
        {
            $this->setError(JText::_('COM_CWTRAFFIC_ERROR_VALID_CITY'));
            return false;
        }

        return true;
    }

    /**
     * Method to store a row
     *
     * @param   boolean  $updateNulls  True to update fields even if they are null.
     *
     * @return  boolean  True on success, false on failure.
     */
    public function store($updateNulls = false)
    {
        $table = JTable::getInstance('Location', 'CoalawebtrafficTable');

        // Let get our country name
        $json = file_get_contents(JPATH_COMPONENT . '/assets/countries/country-code.json');
        $obj = json_decode($json, true);
        foreach ($obj as $key => $value) {
            if ($this->country_code == strtolower($value['Code'])) {
                $this->country_name = $value['Name'];
            }

        }

        //If no City then Country Name and Code must be unique
        if ($this->type == 1) {
            if ($table->load(array('country_code' => $this->country_code, 'country_name' => $this->country_name, 'country_name' => NULL)) && ($table->id != $this->id || $this->id == 0)) {
                $this->setError(JText::_('COM_CWTRAFFIC_ERROR_UNIQUE_COUNTRY'));
                return false;
            }
            $this->city = '';
        }

        // If city is present it must be unique
        if ($this->type == 2 && $table->load(array('city' => $this->city)) && ($table->id != $this->id || $this->id == 0)) {
            $this->setError(JText::_('COM_CWTRAFFIC_ERROR_UNIQUE_CITY'));
            return false;
        }


        // Store the new row
        parent::store($updateNulls);

        return true;

    }

    /**
     * Method to set the publishing state for a row or list of rows in the database
     * table.  The method respects checked out rows by other users and will attempt
     * to checkin rows that it can after adjustments are made.
     *
     * @param   mixed    $pks     An optional array of primary key values to update.  If not set the instance property value is used.
     * @param   integer  $state   The publishing state. eg. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
     * @param   integer  $userId  The user id of the user performing the operation.
     *
     * @return  boolean  True on success.
     *
     * @since   1.0.4
     */
    public function publish($pks = null, $state = 1, $userId = 0)
    {
        $k = $this->_tbl_key;

        // Sanitize input.
        $pks    = ArrayHelper::toInteger($pks);
        $userId = (int) $userId;
        $state  = (int) $state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks))
        {
            if ($this->$k)
            {
                $pks = array($this->$k);
            }
            // Nothing to set publishing state on, return false.
            else
            {
                $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));

                return false;
            }
        }

        // Build the WHERE clause for the primary keys.
        $where = $k . '=' . implode(' OR ' . $k . '=', $pks);

        // Determine if there is checkin support for the table.
        if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
        {
            $checkin = '';
        }
        else
        {
            $checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
        }

        // Update the publishing state for rows with the given primary keys.
        $this->_db->setQuery(
            'UPDATE ' . $this->_db->quoteName($this->_tbl)
            . ' SET ' . $this->_db->quoteName('state') . ' = ' . (int) $state
            . ' WHERE (' . $where . ')'
            . $checkin
        );

        try
        {
            $this->_db->execute();
        }
        catch (RuntimeException $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

        // If checkin is supported and all rows were adjusted, check them in.
        if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
        {
            // Checkin the rows.
            foreach ($pks as $pk)
            {
                $this->checkin($pk);
            }
        }

        // If the JTable instance value is in the list of primary keys that were set, set the instance.
        if (in_array($this->$k, $pks))
        {
            $this->state = $state;
        }

        $this->setError('');

        return true;
    }
}
