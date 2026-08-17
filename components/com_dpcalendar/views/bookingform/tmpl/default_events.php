<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

if ($this->bookingId) {
	return;
}
?>
<div class="com-dpcalendar-bookingform__events">
	<?php if ($this->event && (int)$this->event->original_id > 0) { ?>
		<div class="com-dpcalendar-bookingform__series dp-booking-series">
			<?php $field = $this->form->getField('series'); ?>
			<span class="dp-booking-series__description"><?php echo $this->translate($field->__get('description')); ?></span>
			<span class="dp-booking-series__input"><?php echo $field->__get('input'); ?></span>
		</div>
	<?php } ?>
	<div class="dp-events-list">
		<?php foreach ($this->events as $index => $instance) { ?>
			<div class="dp-event dp-event_<?php echo $instance->id == $this->event->id ? 'original' : 'instance'; ?>"
				 data-event-id="<?php echo $instance->id; ?>">
				<h4 class="dp-heading">
					<span class="dp-event__title"><?php echo $instance->title; ?></span>
					<span class="dp-event__date">
						<?php echo $this->dateHelper->getDateStringFromEvent(
							$instance,
							$this->params->get('event_date_format', 'm.d.Y'),
							$this->params->get('event_time_format', 'g:i a')
						); ?>
					</span>
				</h4>
				<table class="dp-event__tickets dp-table">
					<thead>
					<tr class="dp-ticket">
						<th class="dp-ticket__title" <?php echo !$this->needsPayment ? 'colspan="2"' : ''; ?>><?php echo $this->translate('COM_DPCALENDAR_TICKETS'); ?></th>
						<?php if ($this->needsPayment) { ?>
							<th class="dp-ticket__price"><?php echo $this->translate('COM_DPCALENDAR_FIELD_PRICE_PRICE_LABEL'); ?></th>
						<?php } ?>
						<th class="dp-ticket__amount"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_AMOUNT_LABEL'); ?></th>
						<th class="dp-ticket__calculated-price" colspan="2">
							<?php if ($this->needsPayment) { ?>
								<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_TOTAL'); ?>
							<?php } ?>
						</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($instance->price->value as $key => $value) { ?>
						<tr class="dp-ticket" data-ticket-price="<?php echo $key; ?>">
							<td class="dp-ticket__title" <?php echo !$this->needsPayment ? 'colspan="2"' : ''; ?>
								data-column="<?php echo $this->translate('COM_DPCALENDAR_TICKETS'); ?>">
								<?php echo $instance->price->label[$key]; ?>
							</td>
							<?php if ($this->needsPayment) { ?>
								<td class="dp-ticket__price"
									data-column="<?php echo $this->translate('COM_DPCALENDAR_FIELD_PRICE_PRICE_LABEL'); ?>">
									<?php echo DPCalendarHelper::renderPrice($value); ?>
								</td>
							<?php } ?>
							<td class="dp-ticket__amount" data-column="<?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_AMOUNT_LABEL'); ?>">
								<?php if ($instance->ticket_count == 0) { ?>
									<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKINGFORM_CHOOSE_TICKET_LIMIT_REACHED'); ?>
								<?php } else { ?>
									<?php $name = $this->form->getFormControl() . '[event_id][' . $instance->id . '][tickets][' . $key . ']'; ?>
									<select name="<?php echo $name; ?>" class="dp-select">
										<?php for ($i = 0; $i <= $instance->ticket_count; $i++) { ?>
											<?php $selected = count($instance->price->value) == 1 && $i == 1 && $instance->id == $this->event->id ? 'selected="selected"' : ''; ?>
											<option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
										<?php } ?>
									</select>
								<?php } ?>
							</td>
							<?php if ($this->needsPayment) { ?>
								<td class="dp-ticket__price-info">
									<?php $title = $this->translate('COM_DPCALENDAR_VIEW_BOOKINGFORM_DISCOUNT'); ?>
									<?php echo $this->layoutHelper->renderLayout('block.icon',
										['icon' => \DPCalendar\HTML\Block\Icon::INFO, 'title' => $title]); ?>
								</td>
							<?php } ?>
							<td class="dp-ticket__calculated-price dp-price"
								data-column="<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_TOTAL'); ?>">
								<?php if ($this->needsPayment) { ?>
									<div class="dp-price__live"><?php echo DPCalendarHelper::renderPrice('0.00'); ?></div>
									<div class="dp-price__original dp-price_hidden"><?php echo DPCalendarHelper::renderPrice('0.00'); ?></div>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<?php if ($instance->booking_options) { ?>
						<thead>
						<tr class="dp-ticket">
							<th class="dp-ticket__title"><?php echo $this->translate('COM_DPCALENDAR_OPTIONS'); ?></th>
							<th class="dp-ticket__price"><?php echo $this->translate('COM_DPCALENDAR_FIELD_PRICE_PRICE_LABEL'); ?></th>
							<th class="dp-ticket__amount"><?php echo $this->translate('COM_DPCALENDAR_BOOKING_FIELD_AMOUNT_LABEL'); ?></th>
							<th class="dp-ticket__calculated-price" colspan="2">
								<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_TOTAL'); ?>
							</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($instance->booking_options as $key => $option) { ?>
							<?php $key = preg_replace('/\D/', '', $key); ?>
							<tr class="dp-option" data-option-price="<?php echo $key; ?>">
								<td class="dp-option__title"><?php echo $option->label; ?></td>
								<td class="dp-option__price"><?php echo DPCalendarHelper::renderPrice($option->price); ?></td>
								<td class="dp-option__amount">
									<?php $name = $this->form->getFormControl() . '[event_id][' . $instance->id . '][options][' . $key . ']'; ?>
									<select name="<?php echo $name; ?>" class="dp-select">
										<?php for ($i = 0; $i <= $option->amount; $i++) { ?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</td>
								<td class="dp-option__calculated-price dp-price" colspan="2">
									<div class="dp-price__live"><?php echo DPCalendarHelper::renderPrice('0.00'); ?></div>
									<div class="dp-price__original dp-price_hidden"></div>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					<?php } ?>
				</table>
			</div>
		<?php } ?>
	</div>
	<?php if ($this->needsPayment || $this->booking->state == 3 || $instance->booking_options) { ?>
		<div class="com-dpcalendar-bookingform__total dp-price-total">
			<span class="dp-price-total__label"><?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_TOTAL'); ?>: </span>
			<span class="dp-price-total__content">
			<?php echo DPCalendarHelper::renderPrice($this->booking && $this->booking->id ? $this->booking->price : 0.00); ?>
		</span>
		</div>
	<?php } ?>
</div>
