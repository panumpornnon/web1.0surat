<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

if (!$this->needsPayment || ($this->bookingId && $this->booking->state != 3)) {
	return;
}
?>
<div class="com-dpcalendar-bookingform__payment">
	<div class="com-dpcalendar-bookingform__payment-options">
		<div class="dp-info-box">
			<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_CHOOSE_PAYMENT_OPTION'); ?>
		</div>
		<?php foreach ($this->plugins as $key => $plugin) { ?>
			<label class="dp-payment-option dp-payment-option-<?php echo $plugin->name; ?>">
				<input class="dp-payment-option__input dp-input dp-input-radio"
					   name="paymentmethod" value="<?php echo $plugin->name; ?>" type="checkbox">
				<img class="dp-payment-option__image"
					 src="<?php echo 'plugins/' . $plugin->type . '/' . $plugin->name . '/images/' . $plugin->name . '.png'; ?>">
				<p class="dp-payment-option__text">
					<?php echo $this->translate('PLG_' . strtoupper($plugin->type . '_' . $plugin->name) . '_PAY_BUTTON_DESC'); ?>
				</p>
			</label>
		<?php } ?>
	</div>
</div>
