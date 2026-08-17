<?php

/**
 * Wrapper FormField
 *
 * @version    4.1.1
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

class JFormFieldRH_Wrapper extends JFormField
{
    public $type = 'Wrapper';
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
            if ($start)
            {
                $html[] = '<div id="rh_wrapper_outer" class="rh_wrapper_padding"><div id="rh_wrapper" class="'  . $class . '">';
                $html[] = '
                    <header class="rh_header">
                        <nav class="rh_navbar">
                            <div class="rh_navbar-header bg-darker">
                                <a class="rh_navbar-icon rh_text-brand">
                                    <span class="rh_icon_text">ampz</span>
                                </a>
                            </div>
                            <a href="http://www.roosterz.nl" target="_blank" rel="noopener" id="rh_logo_full" class="rh_logo fadeInTopBig animated_slow"></a>
                            <a href="index.php?option=com_ampz" id="rh_ampz_stats"><i class="rh_icon-stats"></i><span>statistics</span></a>
                        </nav>
                    </header>';
                $html[] = '<div id="rh_wrapper_sides" class="rh_tabs" >';
                $html[] = '<ul class="adminformlist"><li>';
            }
            if ($end)
            {
                $html[] = '<div style="clear: both;"></div></li></ul>';
                $html[] = '<div style="clear: both;"></div>';
                $html[] = '</div></div></div>';
            }

            return implode('', $html);
        }
        else if ( (substr(JVERSION,0,1) == "3") || (substr(JVERSION,0,1) == "4") ) // Joomla 3.x or Joomla 4.x
        {
            if ($start)
            {
                $joomla_version = substr(JVERSION,0,1);

                if ($joomla_version == 4) {
                    require_once JPATH_ADMINISTRATOR . '/components/com_ampz/helpers/ampz.php';
        			AmpzHelper::fixFieldTooltips();
        		}

                $html[] = '</div>';
                $html[] = '<div id="rh_wrapper_outer"><div id="rh_wrapper" class="joomla' . $joomla_version . $class . '">';
                $html[] = '
                    <header class="rh_header">
                        <nav class="rh_navbar">
                            <div class="rh_navbar-header bg-darker">
                                <a class="rh_navbar-icon rh_text-brand">
                                    <span class="rh_icon_text"></span>
                                </a>
                            </div>
                            <a href="http://www.roosterz.nl" target="_blank" rel="noopener" id="rh_logo_full" class="rh_logo fadeInTopBig animated_slow"></a>
                            <div id="rh_ampz_stats">
                                <a href="index.php?option=com_ampz" title="Statistics"><i class="rh_icon-stats"></i></a>
                                <a href="index.php?option=com_ampz&view=shortcodes" title="Shortcodes"><i class="rh_icon-code"></i></a>
                            </div>
                        </nav>
                    </header>';

                $html[] = '<div><div>';
            }
            if ($end)
            {
                $html[] = '</div></div></div><div><div>';
            }

            return '</div>' . implode('', $html);
        }

    }

    private function get($val, $default = '')
    {
        return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
    }
}
