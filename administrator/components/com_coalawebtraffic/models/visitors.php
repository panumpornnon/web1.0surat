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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

use Joomla\Utilities\ArrayHelper;

/**
 * Methods supporting a list of visitor records.
 *
 * @package    Joomla.Administrator
 * @subpackage com_coalawebtraffic
 */
class CoalawebtrafficModelVisitors extends JModelList
{

    /**
     * Constructor.
     *
     * @param array    An optional associative array of configuration settings.
     * @see   JController
     */
    public function __construct($config = array()) 
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'tm', 'a.tm',
                'ip', 'a.ip',
                'iphash', 'a.iphash',
                'referer', 'a.referer',
                'browser', 'a.browser',
                'bversion', 'a.bversion',
                'platform', 'a.platform',
                'country_name', 'a.country_name',
                'city', 'a.city'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param string $ordering  An optional ordering field.
     * @param string $direction An optional direction (asc|desc).
     *
     * @return void
     */
    protected function populateState($ordering = null, $direction = null) 
    {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $browser = $this->getUserStateFromRequest($this->context.'.filter.browser', 'filter_browser', '');
        $this->setState('filter.browser', $browser);
        
        $platform = $this->getUserStateFromRequest($this->context.'.filter.platform', 'filter_platform', '');
        $this->setState('filter.platform', $platform);
        
        $country_name = $this->getUserStateFromRequest($this->context.'.filter.country_name', 'filter_country_name', '');
        $this->setState('filter.country_name', $country_name);
        
        // Load the parameters.
        $params = JComponentHelper::getParams('com_coalawebtraffic');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.tm', 'desc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param string $id A prefix for the store id.
     * 
     * @return string        A store id.
     */
    protected function getStoreId($id = '') 
    {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.platform');
        $id .= ':' . $this->getState('filter.browser');
        $id .= ':' . $this->getState('filter.country_name');

        return parent::getStoreId($id);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return string    An SQL query
     */
    protected function getListQuery() 
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser();

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select', 'a.id, a.tm, DATE(FROM_UNIXTIME(tm)) AS date, '
                        . 'a.ip, a.iphash, a.browser, a.bversion, a.platform, a.referer AS referer, '
                . 'a.country_code, a.country_name as country_name, a.city as city'
            )
        );
        // From the cwtraffic table
        $query->from($db->qn('#__cwtraffic') . ' AS a');

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%' . $db->escape($search, true) . '%');
            $query->where(
                '(' . $db->qn('a.ip') . ' LIKE ' . $search .
                    ' OR DATE(FROM_UNIXTIME(tm)) LIKE ' . $search . ')'
            );
        }
        // Filter by Browser.
        if ($browser = $this->getState('filter.browser')) {
            $query->where('a.browser = ' . $db->q($db->escape($browser)));
        }

        // Filter by type
        if ($platform = $this->getState('filter.platform')) {
            $query->where('a.platform = ' . $db->q($db->escape($platform)));
        }
        
        // Filter by country_name
        if ($country_name = $this->getState('filter.country_name')) {
            $query->where('a.country_name = ' . $db->q($db->escape($country_name)));
        }
                
        // Add the list ordering clause.
        $query->order($db->escape($this->getState('list.ordering', 'a.tm')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));


        return $query;
    }
    
    /**
     * Method to build an SQL query to load the Knownip data.
     *
     * @return string    An SQL query
     */
    public function getKnownips() 
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select('a.ip AS ip, a.title AS title');
        $query->from($db->qn('#__cwtraffic_knownips') . ' AS a');
        $query->where('state = 1');
        $db->setQuery($query);

        try {
            $row = $db->loadRowList();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return null;
        }
        
        return $row;
    }

    /**
     * Get data with the help of the visitors model
     *
     * @param array $inputs
     *
     * @return query
     */
    public function getCsvData($inputs = array())
    {
        $storeRaw = JComponentHelper::getParams('com_coalawebtraffic')->get('store_raw', 1);

        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        if ($storeRaw) {
            $query->select('a.id AS ID, a.tm AS Date, a.tm AS Time, a.ip as IP, a.browser as Browser, a.bversion as Version, a.platform as Platform, a.country_name AS Country, a.city AS City');
        } else {
            $query->select('a.id AS ID, a.tm AS Date, a.tm AS Time, a.browser as Browser, a.bversion as Version, a.platform as Platform, a.country_name AS Country, a.city AS City');
        }

        $query->from($db->qn('#__cwtraffic') . ' AS a');

        // order most recent first
        $query->order($db->qn('a.tm') . ' DESC ');

        // If max only return that many records
        if($inputs['max']) {
            $db->setQuery($query, 0, $inputs['max']);
        } else{
            $db->setQuery($query);
        }

        try {
            $data = $db->loadObjectList();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return null;
        }

        return $data;
    }

}

