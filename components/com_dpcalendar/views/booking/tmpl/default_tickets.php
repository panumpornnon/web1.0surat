<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$format = $this->params->get('event_date_format', 'm.d.Y') . ' ' . $this->params->get('event_time_format', 'g:i a');

$hasPrice = false;
foreach ($this->tickets as $tickets) {
	foreach ($tickets as $ticket) {
		if ($ticket->price && $ticket->price != '0.00') {
			$hasPrice = true;
			break;
		}
	}
}
?>
<div class="com-dpcalendar-booking__tickets">
	<?php foreach ($this->tickets as $eventId => $tickets) { ?>
		<h3 class="dp-heading">
			<span class="dp-heading__event-label"><?php echo $this->translate('COM_DPCALENDAR_EVENT'); ?>: </span>
			<span class="dp-heading__event-title"><?php echo $tickets[0]->event_title; ?></span>
			<span class="dp-heading__event-date"><?php echo $this->dateHelper->getDateStringFromEvent($tickets[0]); ?></span>
		</h3>
		<?php foreach ($tickets as $ticket) { ?>
			<div class="dp-ticket dp-grid">
				<div class="dp-column">
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_TICKET'); ?></dt>
						<dd class="dp-description__description">
							<a href="<?php echo $this->router->getTicketFormRoute($ticket->id); ?>" class="dp-link">
								<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::EDIT]); ?>
							</a>
							<a href="<?php echo $this->router->getTicketRoute($ticket); ?>" title="<?php echo $ticket->uid; ?>" class="dp-link">
								<?php if ($ticket->price_label) { ?>
									<?php echo $ticket->price_label; ?>
								<?php } else { ?>
									<?php echo JHtmlString::abridge($ticket->uid, 15, 5); ?>
								<?php } ?>
							</a>
						</dd>
					</dl>
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_VIEW_EVENTS_MODAL_COLUMN_STATE'); ?></dt>
						<dd class="dp-description__description"><?php echo \DPCalendar\Helper\Booking::getStatusLabel($ticket); ?></dd>
					</dl>
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_NAME_LABEL'); ?></dt>
						<dd class="dp-description__description"><?php echo $ticket->name; ?></dd>
					</dl>
				</div>
				<div class="dp-column">
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_LOCATION'); ?></dt>
						<dd class="dp-description__description"><?php echo \DPCalendar\Helper\Location::format([$ticket]); ?></dd>
					</dl>
					<?php if ($this->params->get('ticket_show_seat', 1)) { ?>
						<dl class="dp-description">
							<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_SEAT_LABEL'); ?></dt>
							<dd class="dp-description__description"><?php echo $ticket->seat; ?></dd>
						</dl>
					<?php } ?>
					<?php if ($hasPrice) { ?>
						<dl class="dp-description">
							<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?></dt>
							<dd class="dp-description__description"><?php echo DPCalendarHelper::renderPrice($ticket->price); ?></dd>
						</dl>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php if (!empty($this->eventOptions[$eventId])) { ?>
			<?php foreach ($this->eventOptions[$eventId] as $option) { ?>
				<div class="dp-option">
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_OPTION'); ?></dt>
						<dd class="dp-description__description"><?php echo $option['label']; ?></dd>
					</dl>
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?></dt>
						<dd class="dp-description__description"><?php echo DPCalendarHelper::renderPrice($option['price']); ?></dd>
					</dl>
					<dl class="dp-description">
						<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_AMOUNT_LABEL'); ?></dt>
						<dd class="dp-description__description"><?php echo $option['amount']; ?></dd>
					</dl>
				</div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
</div>
