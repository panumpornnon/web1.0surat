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

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * View class for Known IP
 */
class CoalawebtrafficViewKnownip extends JViewLegacy
{

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     *
     * @param string $tpl The name of the template file to parse; automatically searches through the template paths.
     *
     * @return void
     * @throws Exception
     */
    public function display($tpl = null) 
    {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }

        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolbar();
            JHtml::_('jquery.framework');
        }
        
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return void
     */
    protected function addToolbar() 
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));

        // Since we don't track these assets at the item level, use the category id.
        $canDo = JHelperContent::getActions('com_coalawebtraffic', 'category', $this->item->catid);

        JToolBarHelper::title($isNew ? JText::_('COM_CWTRAFFIC_TITLE_NEW') : JText::_('COM_CWTRAFFIC_TITLE_EDIT'), 'pencil');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || (count($user->getAuthorisedCategories('com_coalawebtraffic', 'core.create'))))) {
            JToolBarHelper::apply('knownip.apply');
            JToolBarHelper::save('knownip.save');
        }
        if (!$checkedOut && (count($user->getAuthorisedCategories('com_coalawebtraffic', 'core.create')))) {
            JToolBarHelper::save2new('knownip.save2new');
        }
        // If an existing item, can save to a copy.
        if (!$isNew && (count($user->getAuthorisedCategories('com_coalawebtraffic', 'core.create')) > 0)) {
            JToolBarHelper::save2copy('knownip.save2copy');
        }
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('knownip.cancel');
        } else {
            JToolBarHelper::cancel('knownip.cancel', 'JTOOLBAR_CLOSE');
        }

        $help_url = 'https://coalaweb.com/support/documentation/item/coalaweb-traffic-guide';
        JToolBarHelper::help('COM_CWTRAFFIC_TITLE_HELP', false, $help_url);
    }

}
