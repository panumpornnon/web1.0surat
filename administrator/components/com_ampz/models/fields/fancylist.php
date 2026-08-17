<?php
/**
 * FancyList FormField
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldrh_fancylist4 extends JFormField
{
    protected $type = 'FancyList';

    protected function getInput()
    {
        $html = array();
        $attr = '';

        // Initialize some field attributes.
        $attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
        $attr .= $this->multiple ? ' multiple' : '';
        $attr .= $this->required ? ' required aria-required="true"' : '';
        $attr .= $this->autofocus ? ' autofocus' : '';

        // To avoid user's confusion, readonly="true" should imply disabled="true".
        if ((string) $this->readonly == '1' || (string) $this->readonly == 'true' || (string) $this->disabled == '1'|| (string) $this->disabled == 'true')
        {
            $attr .= ' disabled="disabled"';
        }

        // Initialize JavaScript field attributes.
        $attr .= $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

        // Get the field options.
        $options = (array) $this->getOptions();

        // Create a read-only list (no name) with hidden input(s) to store the value(s).
        if ((string) $this->readonly == '1' || (string) $this->readonly == 'true')
        {
            $html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);

            // E.g. form field type tag sends $this->value as array
            if ($this->multiple && is_array($this->value))
            {
                if (!count($this->value))
                {
                    $this->value[] = '';
                }

                foreach ($this->value as $value)
                {
                    $html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '"/>';
                }
            }
            else
            {
                $html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"/>';
            }
        }
        else
            // Create a regular list.
        {
            $html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
            foreach ($options as $i => $option)
            {
                //$html[] = '<div id="'. $option->option_id .'" class="rh_option_toggle" style="display:none">'. JText::_($option->labels).'</div>';
                $html[] = '<div id="'. $option->option_id .'" class="rh_option_toggle" style="display:none"><div id="'. $option->option_id .'"></div></div>';
            }
        }

        return implode($html);
    }

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
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

            // Filter requirements
            if ($requires = explode(',', (string) $option['requires']))
            {
                // Requires multilanguage
                if (in_array('multilanguage', $requires) && !JLanguageMultilang::isEnabled())
                {
                    continue;
                }

                // Requires associations
                if (in_array('associations', $requires) && !JLanguageAssociations::isEnabled())
                {
                    continue;
                }
            }

            $value = (string) $option['value'];

            $disabled = (string) $option['disabled'];
            $disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

            $disabled = $disabled || ($this->readonly && $value != $this->value);

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_(
                'select.option', $value,
                JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
                $disabled
            );

            // Set some option attributes.
            $tmp->option_id = $value;
            $tmp->labels = (string) $option['labels'];
            $tmp->class = (string) $option['class'];

            // Set some JavaScript option attributes.
            $tmp->onclick = (string) $option['onclick'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }
}
