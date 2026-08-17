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
 * View class for Geo Upload
 */
class CoalawebtrafficViewManage extends JViewLegacy
{
    protected $form;
    protected $initial;
    protected $isPro;

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
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
        }
        
        // Is this the Professional release?
        $isPro = (COM_CWTRAFFIC_PRO == 1);
        $this->isPro = $isPro;

        //Should we offer the location initial button?
        $comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $this->initial = $comParams->get('location_initial', 0);

        // Load export report form
        $this->form = JForm::getInstance('csv', JPATH_COMPONENT_ADMINISTRATOR . '/models/forms/csv.xml');

        CoalawebtrafficHelper::addSubmenu('manage');

        // We don't need toolbar in the modal window.
        if ($this->getLayout() !== 'modal') {
            $this->addToolBar();
            $this->sidebar = JHtmlSidebar::render();
        }
        $this->jsOptions['url'] = JURI::base();
        
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return void
     */
    protected function addToolbar() 
    {
        $canDo = JHelperContent::getActions('com_coalawebtraffic');

        $title = COM_CWTRAFFIC_PRO == 1 ? JText::_('COM_CWTRAFFIC_TITLE_PRO') : JText::_('COM_CWTRAFFIC_TITLE_CORE');
        JToolBarHelper::title($title . ' [ ' . JText::_('COM_CWTRAFFIC_TITLE_MANAGE') . ' ]', 'cog');

        $bar = JToolBar::getInstance('toolbar');
        $bar->appendButton('Link', 'wrench', 'COM_CWTRAFFIC_TITLE_CPANEL', 'index.php?option=com_coalawebtraffic');

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_coalawebtraffic');
        }

        $help_url = 'https://coalaweb.com/support/documentation/item/coalaweb-traffic-guide';
        JToolBarHelper::help('COM_CWTRAFFIC_TITLE_HELP', false, $help_url);
    }

}
