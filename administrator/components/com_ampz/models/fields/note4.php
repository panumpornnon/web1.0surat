<?php
/**
 * Note FormField
 * @package AMPZ
 * @Copyright (C) 2013 JooMarketer.com
 * @ All rights reserved
 * @ Joomla! is Free Software
 * @ Released under GNU/GPL v3.0 License : hhttp://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('text');

class JFormFieldNote4 extends JFormFieldText
{
    protected $type = 'Note4';

    protected function getLabel()
    {
    	return '';
    }

    public function getInput()
    {
        $text  	= (string) $this->element['text'];
        $class 	= (string) $this->element['class'];
        return '<div class="'. $class .' note'.(($text != '') ? ' hasText' : '').'"><span>' . JText::_($text) . '</span></div>';
    }
}
