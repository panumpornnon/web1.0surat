<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

$fields = $this->form->getFieldset();
\DPCalendar\Helper\DPCalendarHelper::sortFields($fields, $this->params->get('ticket_form_fields_order_', new stdClass()));
?>
<div class="com-dpcalendar-ticketform__fields">
	<?php foreach ($fields as $field) { ?>
		<?php if ($field->fieldname == 'remind_type') { ?>
			<?php continue; ?>
		<?php } ?>
		<?php if ($field->fieldname == 'remind_time') { ?>
			<?php $data = [
				'label' => $this->form->getLabel('remind_time'),
				'input' => $this->form->getInput('remind_time') . $this->form->getInput('remind_type')
			]; ?>
			<?php echo $this->layoutHelper->renderLayout('joomla.form.renderfield', $data); ?>
			<?php continue; ?>
		<?php } ?>
		<?php echo $field->renderField(['class' => 'dp-field-' . str_replace('_', '-', $field->fieldname)]); ?>
	<?php } ?>
</div>
