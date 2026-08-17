<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

if (!$this->tickets) {
	return;
}

$format = $this->params->get('event_date_format', 'm.d.Y') . ' ' . $this->params->get('event_time_format', 'g:i a');

$hasPrice = false;
foreach ($this->tickets as $ticket) {
	if ($ticket->price && $ticket->price != '0.00') {
		$hasPrice = true;
		break;
	}
}
?>
<div class="com-dpcalendar-tickets__table">
	<table class="dp-table">
		<thead>
		<tr>
			<th><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_ID_LABEL'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_EVENT'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_DATE'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_VIEW_EVENTS_MODAL_COLUMN_STATE'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_NAME_LABEL'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_LOCATION'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_CREATED_DATE'); ?></th>
			<?php if ($this->params->get('ticket_show_seat', 1)) { ?>
				<th><?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_SEAT_LABEL'); ?></th>
			<?php } ?>
			<?php if ($hasPrice) { ?>
				<th><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?></th>
			<?php } ?>
			<?php foreach ($this->tickets[0]->jcfields as $field) { ?>
				<th><?php echo $field->label; ?></th>
			<?php } ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($this->tickets as $ticket) { ?>
			<tr class="dp-ticket">
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_ID_LABEL'); ?>">
					<?php if ($ticket->params->get('access-edit')) { ?>
						<a href="<?php echo $this->router->getTicketFormRoute($ticket->id); ?>" class="dp-link dp-ticket__form-link">
							<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::EDIT]); ?>
						</a>
					<?php } ?>
					<a href="<?php echo $this->router->getTicketRoute($ticket); ?>" class="dp-link dp-ticket__link">
						<?php echo $ticket->price_label ?: JHtmlString::abridge($ticket->uid, 15, 5); ?>
					</a>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_EVENT'); ?>">
					<a href="<?php echo $this->router->getEventRoute($ticket->event_id, $ticket->event_calid); ?>"
					   class="dp-link dp-ticket__event-link">
						<?php echo $ticket->event_title; ?>
					</a>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_DATE'); ?>" class="dp-ticket__event-date">
					<?php echo $this->dateHelper->getDateStringFromEvent($ticket); ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_VIEW_EVENTS_MODAL_COLUMN_STATE'); ?>" class="dp-ticket__state">
					<?php echo \DPCalendar\Helper\Booking::getStatusLabel($ticket); ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_NAME_LABEL'); ?>" class="dp-ticket__name">
					<?php echo $ticket->name; ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_LOCATION'); ?>" class="dp-ticket__location">
					<?php echo \DPCalendar\Helper\Location::format(array($ticket)) ?: '&nbsp;'; ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_CREATED_DATE'); ?>" class="dp-ticket__created-date">
					<?php echo $this->dateHelper->getDate($ticket->created)->format($format); ?>
				</td>
				<?php if ($this->params->get('ticket_show_seat', 1)) { ?>
					<td data-column="<?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_SEAT_LABEL'); ?>" class="dp-ticket__seat">
						<?php echo $ticket->seat; ?>
					</td>
				<?php } ?>
				<?php if ($hasPrice) { ?>
					<td class="dp-cell-price dp-ticket__price"
						data-column="<?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_SEAT_LABEL'); ?>">
						<?php echo DPCalendarHelper::renderPrice($ticket->price, $this->params->get('currency_symbol', '$')); ?>
					</td>
				<?php } ?>
				<?php foreach ($ticket->jcfields as $field) { ?>
					<td data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?>" class="dp-ticket__field">
						<?php echo $field->value; ?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
