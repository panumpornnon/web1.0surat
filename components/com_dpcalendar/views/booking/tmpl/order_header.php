<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

?>
<div class="com-dpcalendar-booking__actions dp-button-bar dp-print-hide">
	<button type="button" class="dp-button dp-button-action dp-button-booking"
	        data-href="<?php echo DPCalendarHelperRoute::getBookingRoute($this->booking); ?>">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::USERS]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_BOOKING_LABEL'); ?>
	</button>
	<button type="button" class="dp-button dp-button-action dp-button-invoice"
	        data-href="<?php echo $this->router->route('index.php?option=com_dpcalendar&task=booking.invoice&b_id=' . $this->booking->id); ?>">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::DOWNLOAD]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_INVOICE'); ?>
	</button>
	<button type="button" class="dp-button dp-button-action dp-button-print" data-selector=".com-dpcalendar-booking">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PRINTING]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_VIEW_CALENDAR_TOOLBAR_PRINT'); ?>
	</button>
</div>
