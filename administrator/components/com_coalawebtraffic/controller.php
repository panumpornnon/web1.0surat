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

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller for coalawebtraffic component
 */
class CoalawebtrafficController extends JControllerLegacy
{

    protected $default_view = 'Controlpanel';

    /**
     * Method to display a view.
     *
     * @param bool $cachable
     * @param bool $urlparams
     * @return bool|CoalawebtrafficController
     */
    public function display($cachable = false, $urlparams = false) 
    {
        include_once JPATH_COMPONENT . '/helpers/coalawebtraffic.php';
        
        $view = JFactory::getApplication()->input->get('view', 'Controlpanel');
        $layout = JFactory::getApplication()->input->get('layout', 'default');
        $id = JFactory::getApplication()->input->get('id');

        if ($view == 'knownip' && $layout == 'edit' && !$this->checkEditId('com_coalawebtraffic.edit.knownip', $id)) {

            // Somehow the person just went to the form - we don't allow that.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect(JRoute::_('index.php?option=com_coalawebtraffic&view=knownips', false));

            return false;
        }

        parent::display();
        return $this;
    }

}
