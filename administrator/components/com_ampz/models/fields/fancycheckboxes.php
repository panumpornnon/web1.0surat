<?php
/**
 * FancyCheckboxes FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
*/

defined('JPATH_PLATFORM') or die;

class JFormFieldRH_FancyCheckboxes extends JFormField
{
    protected $type = 'FancyCheckboxes';
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

        // Initialize some field attributes.
        $class          = !empty($this->class) ? ' class="checkboxes ' . $this->class . '"' : ' class="checkboxes"';
        $checkedOptions = explode(',', (string) $this->checkedOptions);
        $required       = $this->required ? ' required aria-required="true"' : '';
        $autofocus      = $this->autofocus ? ' autofocus' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('script', 'system/html5fallback.js', false, true);

        // Start the checkbox field output.
        $html[] = '<fieldset id="' . $this->id . '"' . $class . $required . $autofocus . '>';

        // Get the field options.
        $options = $this->getOptions();

        // Build the checkbox field output.
        $html[] = '<ul class="rh_list_locations">';

        foreach ($options as $i => $option)
        {
            // Initialize some option attributes.
            if (!isset($this->value) || empty($this->value))
            {
                $checked = (in_array((string) $option->value, (array) $checkedOptions) ? ' checked' : '');
            }
            else
            {
                $value = !is_array($this->value) ? explode(',', $this->value) : $this->value;
                $checked = (in_array((string) $option->value, $value) ? ' checked' : '');
            }

            $checked = empty($checked) && $option->checked ? ' checked' : $checked;

            $class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
            $labels = !empty($option->labels) ? '<h3 class="tile_title">' . $option->labels . '</h3>' : '';
            $text = !empty($option->text) ? '<p>' . $option->text . '</p>' : '';
            $picture = !empty($option->picture) ? '<div class="' . $option->picture . '"></div>' : '';
            $disabled = !empty($option->disable) || $this->disabled ? ' disabled' : '';

            // Initialize some JavaScript option attributes.
            $onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
            $onchange = !empty($option->onchange) ? ' onchange="' . $option->onchange . '"' : '';

            $html[] = '<li class="rh_row rh_fancycheckbox tile">'. $picture . $labels . $text;
            $endisabled = JText::_("AMPZ_DISABLED"). '|' . JText::_("AMPZ_ENABLED");
            $html[] = '<input type="checkbox" data-labelauty="'.$endisabled.'" id="' . $this->id . $i . '" name="' . $this->name .
                '" value="'
                . htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $onclick . $onchange . $disabled . '/>';

            $html[] = '</li>';
        }

        $html[] = '</ul>';

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
            $picture = (string) $option['picture'];
            $text = (string) JText::_($option['text']);

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_('select.option', (string) $option['value'], trim((string) $option), 'value', 'text', $disabled);

            // Set some option attributes.
            $tmp->class = (string) $option['class'];
            $tmp->checked = $checked;
            $tmp->labels = $labels;
            $tmp->picture = $picture;
            $tmp->text = $text;

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
