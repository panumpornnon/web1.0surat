<?php
/**
 * FancyList FormField for Joomla 4.x
 * @package AMPZ
 * copyright  2022 roosterz.nl
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('list'); 

class JFormFieldrh_fancylist4 extends JFormFieldList
{
    protected $type = 'FancyList4';  

    protected function getInput()
    {
        $InputField =  parent::getInput();

        $html = '';

        $options = (array) $this->getOptions();
        foreach ($options as $i => $option)
            {
                 $html .= '<div id="'. $option->option_id .'" class="rh_option_toggle" style="display:none"><div id="'. $option->option_id .'"></div></div>';
            }

        return $InputField .$html;
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
