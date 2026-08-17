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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;


class CoalawebtrafficControllerVisitors extends JControllerAdmin
{
    
    /**
     * Controller message language prefix
     * 
     * @var   string    The prefix to use with controller messages.
     * @since 1.6
     */
    protected $text_prefix = 'COM_CWTRAFFIC';

    /**
     * Proxy for getModel
     *
     * @param string $name
     * @param string $prefix
     * @param array $config
     *
     * @return JModel
     */
    public function getModel($name = 'Visitor', $prefix = 'CoalawebtrafficModel', $config = array('ignore_request' => true)) 
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }

    /**
     * Get the data together to be exported
     *
     * @param string $prefix
     */
    public function csvReport($prefix = 'CoalawebtrafficModel')
    {
        // First check our token to stop any Cross Site Request Forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $inputs = array(
            'max' => $this->input->getString('max', '')
        );

        // Grab our visitors model
        $model = $this->getModel('Visitors', $prefix, array('ignore_request' => true));

        // Populate our data based on dates
        $data = $model->getCsvData($inputs);

        // No data? Then nothing to export
        if(!$data) {
            $msgType = 'notice';
            $msg = JText::_('COM_CWTRAFFIC_REPORT_NODATA_MSG');
            $this->setRedirect('index.php?option=com_coalawebtraffic&view=manage', $msg, $msgType);
            return;
        }

        // Create and export our report
        $this->exportReport($data);
    }

    /**
     * Export CSV report
     * 
     * @param type $data
     */
    protected function exportReport($data) {

        // Format the Date and Time
       foreach ($data as &$item) {
            $item->Date = JHtml::date($item->Date, 'Y-m-d', false);
            $item->Time = JHtml::date($item->Time, 'H:i', false);
        }

        // Set Headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . 'cw-traffic-visitors.csv');

        if ($fp = fopen('php://output', 'w')) {

            // Output the first row with column headings
            if ($data[0]) {
                fputcsv($fp, array_keys(ArrayHelper::fromObject($data[0])));
            }

            // Output the rows
            foreach ($data as $row) {
                fputcsv($fp, ArrayHelper::fromObject($row));
            }
            // Close file
            fclose($fp);
        }
        JFactory::getApplication()->close();
    }

}
