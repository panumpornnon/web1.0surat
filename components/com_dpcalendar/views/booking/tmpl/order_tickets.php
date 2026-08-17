<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$format = $this->params->get('event_date_format', 'm.d.Y') . ' ' . $this->params->get('event_time_format', 'g:i a');

$tickets  = [];
$hasPrice = false;
foreach ($this->tickets as $sortedTickets) {
	$tickets = array_merge($tickets, $sortedTickets);
	foreach ($sortedTickets as $ticket) {
		if ($ticket->price && $ticket->price != '0.00') {
			$hasPrice = true;
			break;
		}
	}
}
$action = $this->router->route('index.php?option=com_dpcalendar&task=ticketform.saveall');
?>
<div class="com-dpcalendar-booking__tickets dp-print-hide">
	<?php if (count($tickets) > 1) { ?>
		<h3 class="dp-heading"><?php echo $this->translate('COM_DPCALENDAR_INVOICE_TICKET_DETAILS'); ?></h3>
	<?php } ?>
	<div class="com-dpcalendar-booking__tickets-message">
		<?php echo JText::plural('COM_DPCALENDAR_VIEW_BOOKING_ORDER_EDIT_TICKETS_TEXT', count($tickets)); ?>
	</div>
	<form class="com-dpcalendar-booking__form dp-form form-validate" method="post" name="adminForm" id="adminForm" action="<?php echo $action; ?>">
		<?php foreach ($tickets as $ticket) { ?>
			<?php if (count($tickets) > 1) { ?>
				<h4 class="com-dpcalendar-booking__ticket-heading dp-heading">
					<?php if ($ticket->price_label) { ?>
						<?php echo $ticket->price_label; ?>
					<?php } ?>
					<?php if ($hasPrice) { ?>
						[<?php echo DPCalendarHelper::renderPrice($ticket->price); ?>]
					<?php } ?>
					<?php if ($this->params->get('ticket_show_seat', 1)) { ?>
						[<?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_SEAT_LABEL') . ': ' . $ticket->seat; ?>]
					<?php } ?>
				</h4>
			<?php } ?>
			<div class="com-dpcalendar-booking__event-info dp-control">
				<div class="dp-control__label">
					<?php echo $this->translate('COM_DPCALENDAR_EVENT'); ?>
				</div>
				<div class="dp-control__input">
					<a href="<?php echo $this->router->getEventRoute($ticket->event_id, $ticket->event_calid); ?>" class="dp-link">
						<?php echo $ticket->event_title; ?>
					</a>
				</div>
			</div>
			<div class="com-dpcalendar-booking__fields">
				<?php foreach ($this->ticketFormFields[$ticket->id] as $field) { ?>
					<?php echo $field->renderField(['class' => 'dp-field-' . str_replace('_', '-', $field->fieldname)]); ?>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if ($this->captchaField) { ?>
			<?php echo $this->captchaField->renderField(['class' => 'dp-field-' . str_replace('_', '-', $this->captchaField->fieldname)]); ?>
		<?php } ?>
		<input type="hidden" name="task" class="dp-input dp-input-hidden">
		<input type="hidden" name="return" value="<?php echo base64_encode(DPCalendarHelperRoute::getBookingRoute($this->booking)); ?>" class="dp-input dp-input-hidden">
		<input type="hidden" name="tmpl" value="<?php echo $this->input->get('tmpl'); ?>" class="dp-input dp-input-hidden">
		<?php echo JHtml::_('form.token'); ?>
	</form>
	<?php echo $this->loadTemplate('tickets_footer'); ?>
</div>
