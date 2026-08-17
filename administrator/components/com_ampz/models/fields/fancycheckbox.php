<?php
/**
 * FancyCheckbox FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldRH_FancyCheckbox extends JFormField
{
    protected $type = 'FancyCheckbox';
    protected $checked = false;

    public function __get($name)
    {
        switch ($name)
        {
            case 'checked':
                return $this->$name;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        switch ($name)
        {
            case 'checked':
                $value = (string) $value;
                $this->$name = ($value == 'true' || $value == $name || $value == '1');
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
            $checked = (string) $this->element['checked'];
            $this->checked = ($checked == 'true' || $checked == 'checked' || $checked == '1');

            empty($this->value) || $this->checked ? null : $this->checked = true;
        }

        return $return;
    }

    protected function getInput()
    {
        // Initialize some field attributes.
        $class     = !empty($this->element['class']) ? ' class="' . $this->element['class'] . '"' : '';
        $labels    = !empty($this->element['labels']) ? ' data-labelauty="' . $this->element['labels'] . '"' : '';
        $disabled  = $this->disabled ? ' disabled' : '';
        $value     = !empty($this->default) ? $this->default : '1';
        $required  = $this->required ? ' required aria-required="true"' : '';
        $autofocus = $this->autofocus ? ' autofocus' : '';
        $checked   = $this->checked || !empty($this->value) ? ' checked' : '';

        // Initialize JavaScript field attributes.
        $onclick  = !empty($this->onclick) ? ' onclick="' . $this->onclick . '"' : '';
        $onchange = !empty($this->onchange) ? ' onchange="' . $this->onchange . '"' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('script', 'system/html5fallback.js', false, true);

        return '<input type="checkbox" name="' . $this->name . '" id="' . $this->id . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '" ' . $class . $labels . $checked . $disabled . $onclick . $onchange . $required . $autofocus . ' />';
    }
}
