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

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\HTML\HTMLHelper as JHtml;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\MVC\View\HtmlView as JView;
use Joomla\CMS\Object\CMSObject as JObject;
use Joomla\CMS\Toolbar\Toolbar as JToolbar;
use CoalaWeb\Parameters as CW_Parameters;
use CoalaWeb\UpdateKey as CW_UpdateKey;
use CoalaWeb\Xml as CW_Xml;

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');


/**
 * View class for Geo Upload
 */
class CoalawebtrafficViewGeoupload extends JView
{
    protected $config;
    protected $version;
    protected $component;
    protected $proCore;
    protected $license;
    protected $geoExist;

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

        // Load component params
        $this->config    = CW_Parameters::getInstance()->getComponentParams('coalawebtraffic');

        // Load extension data such as the manifest cache
        $this->component = (new CW_UpdateKey)->getExtensionData('com_coalawebtraffic');

        // Is this the PRO or CORE version?
        $xml = JPATH_ADMINISTRATOR . '/components/com_coalawebtraffic/coalawebtraffic.xml';
        $this->extXml = (new CW_Xml)->toObject($xml);
        $this->proCore = $this->extXml->level;
        $this->license = $this->extXml->license;
        
        // What geo location to use
        $dbName = $this->proCore == 'Pro' ? JText::_('COM_CWTRAFFIC_GEO_PRO') : JText::_('COM_CWTRAFFIC_GEO_CORE');
        
        if (CoalawebtrafficHelperLocation::geodatExist()) {
            $mymod = CoalawebtrafficHelperLocation::geodatMod();
            $sprint = array($dbName, $mymod);
            $this->geoMessage = CwGearsHelperTools::getMessage('success', 'COM_CWTRAFFIC_YESGEO_UPLOAD_MESSAGE', $sprint);
            $this->geoExist = true;
        } else {
            $this->geoMessage = JText::_('COM_CWTRAFFIC_NOGEO_UPLOAD_MESSAGE');
            $this->geoExist = false;
        }

        CoalawebtrafficHelper::addSubmenu('geoupload');

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

        $title = JText::_('COM_CWTRAFFIC_TITLE_' . $this->proCore);
        JToolBarHelper::title($title . ' [ ' . JText::_('COM_CWTRAFFIC_TITLE_GEO') . ' ]', 'location');

        $bar = JToolBar::getInstance('toolbar');
        $bar->appendButton('Link', 'wrench', 'COM_CWTRAFFIC_TITLE_CPANEL', 'index.php?option=com_coalawebtraffic');

        if ($canDo->get('core.admin')) {
            if ($this->proCore == 'Pro' && $this->filesExist('archivesv2')) {
                JToolBarHelper::custom('geoupload.unzip', 'box-add', 'box-add', 'Unzip', false);
            } elseif ($this->filesExist('archives')) {
                JToolBarHelper::custom('geoupload.unzip', 'box-add', 'box-add', 'Unzip', false);
            }
        }
        
        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_coalawebtraffic');
        }

        $help_url = 'https://coalaweb.com/support/documentation/item/coalaweb-traffic-guide';
        JToolBarHelper::help('COM_CWTRAFFIC_TITLE_HELP', false, $help_url);
    }

    /**
     * Checks if folder + files exist in the com_coalawebtraffic tmp path
     *
     * @param  $type
     * @return bool
     */
    private function filesExist($type) 
    {
        $path = JFactory::getConfig()->get('tmp_path') . '/com_coalawebtraffic/' . $type;
        if (JFolder::exists($path)) {
            if (JFolder::folders($path, '.', false) || JFolder::files($path, '.', false)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if Curl is installed
     *
     * @return boolean
     */
    function curlInstalled() 
    {
        if (in_array('curl', get_loaded_extensions())) {
            return true;
        } else {
            return false;
        }
    }

}
