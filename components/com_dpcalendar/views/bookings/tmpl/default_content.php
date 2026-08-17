<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$format = $this->params->get('event_date_format', 'm.d.Y') . ' ' . $this->params->get('event_time_format', 'g:i a');
?>
<div class="com-dpcalendar-bookings__table">
	<table class="dp-table">
		<thead>
		<tr>
			<th><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_ID_LABEL'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_VIEW_EVENTS_MODAL_COLUMN_STATE'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_NAME_LABEL'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_INVOICE_DATE'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?></th>
			<th><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_TICKETS_LABEL'); ?></th>
			<?php if ($this->bookings) { ?>
				<?php foreach ($this->bookings[0]->jcfields as $field) { ?>
					<th><?php echo $field->label; ?></th>
				<?php } ?>
			<?php } ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($this->bookings as $booking) { ?>
			<tr class="dp-booking">
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_ID_LABEL'); ?>">
					<a href="<?php echo $this->router->getBookingFormRoute($booking->id); ?>" class="dp-link dp-booking__edit-link">
						<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::EDIT]); ?>
					</a>
					<a href="<?php echo $this->router->getBookingRoute($booking); ?>" class="dp-link dp-booking__link">
						<?php echo JHtmlString::abridge($booking->uid, 15, 5); ?>
					</a>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_VIEW_EVENTS_MODAL_COLUMN_STATE'); ?>" class="dp-booking__state">
					<?php echo \DPCalendar\Helper\Booking::getStatusLabel($booking); ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_NAME_LABEL'); ?>" class="dp-booking__name">
					<?php echo $booking->name; ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_INVOICE_DATE'); ?>" class="dp-booking__date">
					<?php echo $this->dateHelper->getDate($booking->book_date)->format($format, true); ?>
				</td>
				<td class="dp-cell-price dp-booking__price" data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?>">
					<?php echo DPCalendarHelper::renderPrice($booking->price, $this->params->get('currency_symbol', '$')); ?>
				</td>
				<td data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_TICKETS_LABEL'); ?>">
					<a href="<?php echo DPCalendarHelperRoute::getTicketsRoute($booking->id); ?>" class="'dp-link dp-booking__tickets-link">
						<?php echo $booking->amount_tickets; ?>
					</a>
				</td>
				<?php foreach ($booking->jcfields as $field) { ?>
					<td data-column="<?php echo $field->label; ?>" class="dp-booking__field"><?php echo $field->value; ?></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
