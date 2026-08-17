<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

$fields = $this->form->getFieldset();
\DPCalendar\Helper\DPCalendarHelper::sortFields($fields, $this->params->get('booking_form_fields_order_', new stdClass()));
?>
<div class="com-dpcalendar-bookingform__fields">
	<?php foreach ($fields as $field) { ?>
		<?php if (in_array($field->fieldname, ['series', 'event_id', 'amount', 'options'])) { ?>
			<?php continue; ?>
		<?php } ?>
		<?php echo $field->renderField(['class' => 'dp-field-' . str_replace('_', '-', $field->fieldname)]); ?>
	<?php } ?>
	<?php foreach ($this->terms as $article) { ?>
		<input type="checkbox" name="terms" class="dp-input dp-input-checkbox dp-input-terms">
		<?php echo JText::sprintf('COM_DPCALENDAR_VIEW_BOOKINGFORM_TERMS_TEXT', $article->dp_terms_link); ?>
	<?php } ?>
</div>
