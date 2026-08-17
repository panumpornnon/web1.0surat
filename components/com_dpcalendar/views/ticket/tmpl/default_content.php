<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$ticket = $this->ticket;
$event  = $this->event;
?>
<div class="com-dpcalendar-ticket__content dp-ticket">
	<h3 class="dp-heading"><?php echo $event->title; ?></h3>
	<dl class="dp-description">
		<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_DATE'); ?></dt>
		<dd class="dp-description__description">
			<?php echo $this->dateHelper->getDateStringFromEvent(
				$event,
				$this->params->get('event_date_format', 'm.d.Y'), $this->params->get('event_time_format', 'g:i a')
			); ?>
		</dd>
	</dl>
	<?php if (isset($event->locations) && $event->locations) { ?>
		<dl class="dp-description">
			<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_LOCATION'); ?></dt>
			<dd class="dp-description__description">
				<?php foreach ($event->locations as $location) { ?>
					<div class="dp-location">
						<a href="<?php echo $this->router->getLocationRoute($location); ?>" class="dp-link">
							<?php echo $location->title; ?>
						</a>
					</div>
				<?php } ?>
			</dd>
		</dl>
	<?php } ?>
	<h3 class="dp-heading"><?php echo $this->translate('COM_DPCALENDAR_INVOICE_TICKET_DETAILS'); ?></h3>
	<dl class="dp-description">
		<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_ID_LABEL'); ?></dt>
		<dd class="dp-description__description"><?php echo $ticket->uid; ?></dd>
	</dl>
	<?php if ($ticket->price_label) { ?>
		<dl class="dp-description">
			<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_TYPE_LABEL'); ?></dt>
			<dd class="dp-description__description">
				<span class="dp-ticket__type-label"><?php echo $ticket->price_label; ?></span>
				<span class="dp-ticket__type-description"><?php echo $ticket->price_description; ?></span>
			</dd>
		</dl>
	<?php } ?>
	<?php if ($ticket->price && $ticket->price != '0.00') { ?>
		<dl class="dp-description">
			<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?></dt>
			<dd class="dp-description__description">
				<?php echo DPCalendarHelper::renderPrice($ticket->price, $this->params->get('currency_symbol', '$')); ?>
			</dd>
		</dl>
		<dl class="dp-description">
			<dt class="dp-description__label"><?php echo $this->translate('JSTATUS'); ?></dt>
			<dd class="dp-description__description">
				<?php echo \DPCalendar\Helper\Booking::getStatusLabel($ticket); ?>
			</dd>
		</dl>
	<?php } ?>
	<?php foreach ($this->ticketFields as $field) { ?>
		<dl class="dp-description">
			<dt class="dp-description__label"><?php echo $this->translate($field->dpDisplayLabel); ?></dt>
			<dd class="dp-description__description"><?php echo $field->dpDisplayContent; ?></dd>
		</dl>
	<?php } ?>
</div>
