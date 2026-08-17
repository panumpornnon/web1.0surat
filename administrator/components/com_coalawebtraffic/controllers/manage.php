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

jimport('joomla.filesystem');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');

/**
 * Manage controller class.
 *
 * @package    Joomla.Administrator
 * @subpackage com_coalawebtraffic
 */
class CoalawebtrafficControllerManage extends JControllerLegacy {

    /**
     * @var string The prefix to use with controller messages.
     */
    protected $text_prefix = 'COM_CWTRAFFIC';

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JControllerLegacy
     * @since   1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Proxy for getModel
     * 
     * @param type $name
     * @param type $prefix
     * 
     * @return JModel
     */
    public function getModel($name = 'Manage', $prefix = 'CoalawebtrafficModel', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Messages and redirect for purge of Traffic data
     */
    function purge() {
        // First check our token to stop any Cross Site Request Forgeries
        JSession::checkToken('get') or die('Invalid Token');

        $model = $this->getModel();
        $msgType = '';

        if (!$model->purge()) {
            $msg = JText::_('COM_CWTRAFFIC_PURGE_ERROR_MSG');
            $msgType = 'error';
        } else {
            $msg = JText::_('COM_CWTRAFFIC_PURGE_SUCCESS_MSG');
        }
        $this->setRedirect('index.php?option=com_coalawebtraffic&view=manage', $msg, $msgType);
    }

    /**
     * Messages and redirect for purge of Traffic log data
     */
    function purgeLogs()
    {
        // First check our token to stop any Cross Site Request Forgeries
        JSession::checkToken('get') or die('Invalid Token');

        $model = $this->getModel();
        $results = $model->purgeLogs();
        $msgType = '';

        if (!$results['test']) {
            $msg = JText::_('COM_CWTRAFFIC_PURGE_LOGS_ERROR_MSG');
            $msgType = 'error';
        } else {
            if ($results['deleted'] === 0) {
                $msg = JText::_('COM_CWTRAFFIC_PURGE_NOLOGS_SUCCESS_MSG');
            } elseif ($results['deleted'] === 1) {
                $msg = JText::sprintf('COM_CWTRAFFIC_PURGE_LOG_SUCCESS_MSG', $results['deleted']);
            } else {
                $msg = JText::sprintf('COM_CWTRAFFIC_PURGE_LOGS_SUCCESS_MSG', $results['deleted']);
            }
        }
        $this->setRedirect('index.php?option=com_coalawebtraffic&view=manage', $msg, $msgType);
    }

}
