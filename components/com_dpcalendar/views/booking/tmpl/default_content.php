<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
?>
<div class="com-dpcalendar-booking__content dp-grid">
	<?php if ($this->booking->price && $this->booking->price != '0.00') { ?>
		<div class="com-dpcalendar-booking__invoice-details">
			<h3 class="dp-heading"><?php echo $this->translate('COM_DPCALENDAR_INVOICE_INVOICE_DETAILS'); ?></h3>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_INVOICE_NUMBER'); ?></dt>
				<dd class="dp-description__description"><?php echo $this->booking->uid; ?></dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_INVOICE_DATE'); ?></dt>
				<dd class="dp-description__description">
					<?php echo $this->dateHelper->getDate($this->booking->book_date)
						->format($this->params->get('event_date_format', 'm.d.Y') . ' ' . $this->params->get('event_time_format', 'g:i a')); ?>
				</dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PRICE_LABEL'); ?></dt>
				<dd class="dp-description__description">
					<?php echo DPCalendarHelper::renderPrice($this->booking->price, $this->params->get('currency_symbol', '$')); ?>
				</dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_TICKETS_LABEL'); ?></dt>
				<dd class="dp-description__description"><?php echo $this->booking->amount_tickets; ?></dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_OPTIONS'); ?></dt>
				<dd class="dp-description__description"><?php echo $this->booking->amount_options; ?></dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_PROCESSOR_LABEL'); ?></dt>
				<dd class="dp-description__description">
					<?php echo $this->booking->processor ? $this->translate('PLG_DPCALENDARPAY_' . strtoupper($this->booking->processor) . '_TITLE') : ''; ?>
				</dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('JSTATUS'); ?></dt>
				<dd class="dp-description__description"><?php echo \DPCalendar\Helper\Booking::getStatusLabel($this->booking); ?></dd>
			</dl>
		</div>
	<?php } ?>
	<div class="com-dpcalendar-booking__booking-details">
		<h3 class="dp-heading"><?php echo $this->translate('COM_DPCALENDAR_INVOICE_BOOKING_DETAILS'); ?></h3>
		<?php if (!$this->booking->price || $this->booking->price == '0.00') { ?>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_ID_LABEL'); ?></dt>
				<dd class="dp-description__description"><?php echo $this->booking->uid; ?></dd>
			</dl>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_TICKETS_LABEL'); ?></dt>
				<dd class="dp-description__description"><?php echo $this->booking->amount_tickets; ?></dd>
			</dl>
		<?php } ?>
		<?php foreach ($this->bookingFields as $field) { ?>
			<dl class="dp-description">
				<dt class="dp-description__label"><?php echo $this->translate($field->dpDisplayLabel); ?></dt>
				<dd class="dp-description__description"><?php echo $field->dpDisplayContent; ?></dd>
			</dl>
		<?php } ?>
	</div>
</div>
