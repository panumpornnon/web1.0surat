<?php
/**
 * FancyText FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldRH_FancyText extends JFormField
{
    protected $type = 'FancyText';
    protected $maxLength;

    protected $inputmode;

    protected $dirname;

    public function __get($name)
    {
        switch ($name)
        {
            case 'maxLength':
            case 'dirname':
            case 'inputmode':
                return $this->$name;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        switch ($name)
        {
            case 'maxLength':
                $this->maxLength = (int) $value;
                break;

            case 'dirname':
                $value = (string) $value;
                $value = ($value == $name || $value == 'true' || $value == '1');

            case 'inputmode':
                $this->name = (string) $value;
                break;

            default:
                parent::__set($name, $value);
        }
    }

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        $result = parent::setup($element, $value, $group);

        if ($result == true)
        {
            $inputmode = (string) $this->element['inputmode'];
            $dirname = (string) $this->element['dirname'];

            $this->inputmode = '';
            $inputmode = preg_replace('/\s+/', ' ', trim($inputmode));
            $inputmode = explode(' ', $inputmode);

            if (!empty($inputmode))
            {
                $defaultInputmode = in_array('default', $inputmode) ? JText::_("JLIB_FORM_INPUTMODE") . ' ' : '';

                foreach (array_keys($inputmode, 'default') as $key)
                {
                    unset($inputmode[$key]);
                }

                $this->inputmode = $defaultInputmode . implode(" ", $inputmode);
            }

            // Set the dirname.
            $dirname = ((string) $dirname == 'dirname' || $dirname == 'true' || $dirname == '1');
            $this->dirname = $dirname ? $this->getName($this->fieldname . '_dir') : false;

            $this->maxLength = (int) $this->element['maxlength'];
        }

        return $result;
    }

    protected function getInput()
    {
        // Translate placeholder text
        $hint = $this->translateHint ? JText::_($this->hint) : $this->hint;

        // Initialize some field attributes.
        $size         = !empty($this->size) ? ' size="' . $this->size . '"' : '';
        $unit         = !empty($this->element['unit']) ? JText::_($this->element['unit']) : '';
        $maxLength    = !empty($this->maxLength) ? ' maxlength="' . $this->maxLength . '"' : '';
        $class        = !empty($this->class) ? ' class="form-control ' . $this->class . '"' : ' class="form-control"';
        $readonly     = $this->readonly ? ' readonly' : '';
        $disabled     = $this->disabled ? ' disabled' : '';
        $required     = $this->required ? ' required aria-required="true"' : '';
        $hint         = $hint ? ' placeholder="' . $hint . '"' : '';
        $autocomplete = !$this->autocomplete ? ' autocomplete="off"' : ' autocomplete="' . $this->autocomplete . '"';
        $autocomplete = $autocomplete == ' autocomplete="on"' ? '' : $autocomplete;
        $autofocus    = $this->autofocus ? ' autofocus' : '';
        $spellcheck   = $this->spellcheck ? '' : ' spellcheck="false"';
        $pattern      = !empty($this->pattern) ? ' pattern="' . $this->pattern . '"' : '';
        $inputmode    = !empty($this->inputmode) ? ' inputmode="' . $this->inputmode . '"' : '';
        $dirname      = !empty($this->dirname) ? ' dirname="' . $this->dirname . '"' : '';

        // Initialize JavaScript field attributes.
        $onchange = !empty($this->onchange) ? ' onchange="' . $this->onchange . '"' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('script', 'system/html5fallback.js', false, true);

        $datalist = '';
        $list     = '';

        /* Get the field options for the datalist.
        Note: getSuggestions() is deprecated and will be changed to getOptions() with 4.0. */
        $options  = (array) $this->getSuggestions();

        if ($options)
        {
            $datalist = '<datalist id="' . $this->id . '_datalist">';

            foreach ($options as $option)
            {
                if (!$option->value)
                {
                    continue;
                }

                $datalist .= '<option value="' . $option->value . '">' . $option->text . '</option>';
            }

            $datalist .= '</datalist>';
            $list     = ' list="' . $this->id . '_datalist"';
        }

        $html[] = '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . $dirname . ' value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $class . $size . $disabled . $readonly . $list . $hint . $onchange . $maxLength . $required . $autocomplete . $autofocus . $spellcheck . $inputmode . $pattern . ' />';
        $html[] = $datalist;
        $html[] = '<div class="unit">'. $unit .'</div>';

        return implode($html);
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

            // Create a new option object based on the <option /> element.
            $options[] = JHtml::_(
                'select.option', (string) $option['value'],
                JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text'
            );
        }

        return $options;
    }

    /**
     * Method to get the field suggestions.
     *
     * @return  array  The field option objects.
     *
     * @since       3.2
     * @deprecated  4.0  Use getOptions instead
     */
    protected function getSuggestions()
    {
        return $this->getOptions();
    }
}
