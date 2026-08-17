<?php

/**
 * SidebarMenuItem FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

class JFormFieldRH_SidebarMenuItem extends JFormField
{
    public $type = 'SidebarMenuItem';
    private $params = null;

    protected function getLabel()
    {
        return '';
    }

    protected function getInput()
    {
        $this->params = $this->element->attributes();

        $title = JText::_($this->get('label'));
        $active =  $this->get('active');
        $icon = $this->get('icon');
        $link = $this->get('link');

        if (substr(JVERSION,0,1) == "2") // Joomla 2.5
        {
            return '<li '.($active == 1? 'class="active"' : '').'><a href="'.$link.'"><i class="'.$icon.'"></i><span>'.$title
            .'</span></a></li>';
        }
        else if ( (substr(JVERSION,0,1) == "3") || (substr(JVERSION,0,1) == "4") ) // Joomla 3.x or Joomla 4.x
        {
            return '<li '.($active == 1? 'class="active"' : '').'><a href="'.$link.'"><i class="'.$icon.'"></i><span>'.$title
        .'</span></a></li>';

        }
    }

    private function get($val, $default = '')
    {
        return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
    }
}
