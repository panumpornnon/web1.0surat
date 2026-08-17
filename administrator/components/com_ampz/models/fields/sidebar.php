<?php

/**
 * Sidebar FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

class JFormFieldRH_Sidebar extends JFormField
{
    public $type = 'Sidebar';
    private $params = null;

    protected function getLabel()
    {
        return '';
    }

    protected function getInput()
    {
        $this->params = $this->element->attributes();

        $title = $this->get('label');
        $class = $this->get('class');

        $start = $this->get('start', 0);
        $end = $this->get('end', 0);

        $html = array();

        if (substr(JVERSION,0,1) == "2") // Joomla 2.5
        {
            if ($start || !$end)
            {
                $html[] = '<section class="rh_sidebar">';
                $html[] = '<ul class="adminformlist"><li>';
            }
            if ($end)
            {
                $html[] = '<div style="clear: both;"></div></li></ul>';
                $html[] = '</section>';
            }

            return implode('', $html);
        }
        else if ( (substr(JVERSION,0,1) == "3") || (substr(JVERSION,0,1) == "4") ) // Joomla 3.x or Joomla 4.x
        {
            if ($start || !$end)
            {
                $html[] = '</div>';
                $html[] = '<section class="rh_sidebar">';
            }
            if ($end)
            {
                $html[] = '</div></section>';
            }

            $html[] = '<div><div>';

            return '</div>' . implode('', $html);
        }

    }

    private function get($val, $default = '')
    {
        return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
    }
}
