<?php
/**
 * FancySort FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldRH_FancySort extends JFormField
{
    protected $type = 'FancySort';
    protected $forceMultiple = true;
    public $checkedOptions;

    public function __get($name)
    {
        switch ($name)
        {
            case 'forceMultiple':
            case 'checkedOptions':
                return $this->$name;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        switch ($name)
        {
            case 'checkedOptions':
                $this->checkedOptions = (string) $value;
                break;

            default:
                parent::__set($name, $value);
        }
    }

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        $return = parent::setup($element, $value, $group);

        if ($return)
        {
            $this->checkedOptions = (string) $this->element['checked'];
        }

        return $return;
    }

    protected function getInput()
    {
        $html = array();
        $temp_checked = array();
        $temp_unchecked = array();

        // Initialize some field attributes.
        $required       = $this->required ? ' required aria-required="true"' : '';
        $autofocus      = $this->autofocus ? ' autofocus' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('script', 'system/html5fallback.js', false, true);

        // Start the checkbox field output.
        $html[] = '<fieldset id="' . $this->id . '"' . $required . $autofocus . '>';

        // Get the field options.
        $options = $this->getOptions();

        // Get the enabled networks
        if (is_array($this->value)) {
          $enabled_networks = implode(".",$this->value) . ".";
        }
        else { // nothing enabled
          $enabled_networks = ".";
        }

        !empty($this->description) ? $shortcodes = " shortcodes" : $shortcodes = "";

        // Build the checkbox field output.
        $html[] = '<div id="rh_networks_grid"><div class="sortable'. $shortcodes .'"><ol class="sortable-list">';

        foreach ($options as $i => $option)
        {
            $class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
            $network = !empty($option->network) ? $option->network : '';
            $labels = !empty($option->labels) ? JText::_($option->labels) : '';
            $disabled = !empty($option->disable) || $this->disabled ? ' disabled' : '';

            // Initialize some JavaScript option attributes.
            $onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
            $onchange = !empty($option->onchange) ? ' onchange="' . $option->onchange . '"' : '';

            // Check if the network is enabled

            $pos = strpos($enabled_networks, $network);
            if ($pos === false)
            {
                $checked = "";

                $temp_unchecked[] = '<li class="sortable-item '. $network .'" data-id="'. $network .'"><div class="sortable-handle"></div><div class="sortable-content '.  $network.'"><span class="sortable-content-text">'. $labels .'</span><input type="checkbox" id="btn_' . $option->network . '" name="' . $this->name . '" value="' . htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $labels . $onclick . $onchange . $disabled . '/></div></li>';
            }
            else
            {
                $checked = "checked";

                $order_start_pos = $pos + strlen($network) + 1;
                $order = substr($enabled_networks, $order_start_pos, strpos($enabled_networks, '.', $order_start_pos) - $order_start_pos);
                $value = "btn_" . $network . "_" . $order;

                $temp_checked[$order] = '<li class="sortable-item '. $network .'" data-id="'. $network .'"><div class="sortable-handle"></div><div class="sortable-content '.  $network.'"><span class="sortable-content-text">'. $labels .'</span><input type="checkbox" id="btn_' . $option->network . '" name="' . $this->name . '" value="' . $value . '"' . $checked . $class . $labels . $onclick . $onchange . $disabled . '/></div></li>';
            }

        }

        ksort($temp_checked, SORT_NUMERIC);

        $html[] = implode($temp_checked) . implode($temp_unchecked) . '</ol></div></div>';

        // End the checkbox field output.
        $html[] = '</fieldset>';

        if (substr(JVERSION,0,1) == "2") // Joomla 2.5
            return implode($html);
        else if ( (substr(JVERSION,0,1) == "3") || (substr(JVERSION,0,1) == "4") ) // Joomla 3.x or Joomla 4.x
            return '</div></div>' . implode($html) . '<div><div>';
    }

    protected function getOptions()
    {
        $options = array();

        foreach ($this->element->children() as $option)
        {
            // Only add <option /> elements.
            if ($option->getName() != 'option')
            {
                continue;
            }

            $disabled = (string) $option['disabled'];
            $disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

            $checked = (string) $option['checked'];
            $checked = ($checked == 'true' || $checked == 'checked' || $checked == '1');

            $labels = (string) $option['labels'];

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_('select.option', (string) $option['value'], trim((string) $option), 'value', 'text', $disabled);

            // Set some option attributes.
            $tmp->class = (string) $option['class'];
            $tmp->network = (string) $option['network'];
            $tmp->checked = $checked;
            $tmp->labels = $labels;

            // Set some JavaScript option attributes.
            $tmp->onclick = (string) $option['onclick'];
            $tmp->onchange = (string) $option['onchange'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }
}
