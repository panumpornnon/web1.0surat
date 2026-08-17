<?php

/**
 * Tab FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

class JFormFieldRH_Tab extends JFormField
{
    public $type = 'Tab';
    private $params = null;

    protected function getLabel()
    {
        return '';
    }

    protected function getInput()
    {
        $this->params = $this->element->attributes();

        $id = $this->get('id');
        $active = $this->get('active');
        $title = JText::_($this->get('title'));
        $doc_link = JText::_($this->get('doclink', 0));

        $start = $this->get('start', 0);
        $end = $this->get('end', 0);

        $html = array();

        if (substr(JVERSION,0,1) == "2") // Joomla 2.5
        {
            if ($start || !$end)
            {
                $html[] = '</li><div id="'.$id.'" class="rh_tab'.($active == 1? ' active' : '').'">';
                $html[] = '<ul class="adminformlist"><li>';
                $html[] = '<div class="rh_tab-title"><h2>'.$title.'</h2></div>';
            }
            if ($end)
            {
                $html[] = '<div style="clear: both;"></div></li></ul>';
                $html[] = '</div>';
            }

            return implode('', $html);
        }
        else if ( (substr(JVERSION,0,1) == "3") || (substr(JVERSION,0,1) == "4") ) // Joomla 3.x or Joomla 4.x
        {
            if ($start || !$end)
            {
                $html[] = '</div>';
                $html[] = '<div id="'.$id.'" class="rh_tab'.($active == 1? ' active' : '').'">';
                if ($doc_link)
                    $html[] = '<div class="rh_tab-title"><h2>'.$title.'<a target="_blank" rel="noopener" href="'. $doc_link .'"><i class="rh_icon-documentation small"></i></a></h2></div>';
                else {
                    $html[] = '<div class="rh_tab-title"><h2>'.$title.'</h2></div>';
                }
            }
            if ($end)
            {
                $html[] = '</div></div>';
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
