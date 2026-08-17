<?php

/**
 * Side FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

class JFormFieldRH_Side extends JFormField
{
    public $type = 'Side';
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

        $wrap_start = $this->get('wrap_start', 0);
        $wrap_end = $this->get('wrap_end', 0);
        $start = $this->get('start', 0);
        $end = $this->get('end', 0);

        $html = array();

        if (substr(JVERSION,0,1) == "2") // Joomla 2.5
        {
            if ($start)
            {
                $html[] = '<aside class="'.$class.'">';
                if ($class == "rh_right-side") // start the tabs container
                {
                    $html[] = '<div class="rh_tab-content fadeInLeft animated">';
                }
                $html[] = '<ul class="adminformlist"><li>';
            }
            if ($end)
            {
                $html[] = '<div style="clear: both;"></div></li></ul>';
                $html[] = '<div style="clear: both;"></div>';
                if ($class == "rh_right-side") // start the tabs container
                {
                    $html[] = '</div>';
                }
                $html[] = '</aside>';
            }

            return implode('', $html);
        }
        else if ( (substr(JVERSION,0,1) == "3") || (substr(JVERSION,0,1) == "4") ) // Joomla 3.x or Joomla 4.x
        {
            if ($wrap_start)
            {
                $html[] = '</div>';
                $html[] = '<div id="rh_wrapper_sides" class="rh_tabs" >';
                $html[] = '<aside class="'.$class.'">';
            }
            if ($start)
            {
                $html[] = '</div>';
                if ($class == "rh_left-side") // start the tabs container
                {
                    $html[] = '<div id="rh_wrapper_sides" class="rh_tabs" >';
                }
                $html[] = '<aside class="'.$class.'">';
                if ($class == "rh_right-side") // start the tabs container
                {
                    $html[] = '<div class="rh_tab-content fadeInLeft animated">';
                }
            }
            if ($end)
            {
                $html[] = '</div></aside>';
                if ($class == "rh_right-side") // start the tabs container
                {
                    $html[] = '</div>';
                }
            }
            if ($wrap_end)
            {
                $html[] = '</div><!-- end tabs container --></aside></div>';
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
