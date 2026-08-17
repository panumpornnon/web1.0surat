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
	<?php if ($this->booking->state == 5) { ?>
		<button type="button" class="dp-button dp-button-action dp-button-invite-accept"
		        data-href="<?php echo DPCalendarHelperRoute::getInviteChangeRoute($this->booking, true, false); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::OK]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_INVITE_ACCEPT'); ?>
		</button>
		<button type="button" class="dp-button dp-button-action dp-button-invite-decline"
		        data-href="<?php echo DPCalendarHelperRoute::getInviteChangeRoute($this->booking, false, false); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::OK]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_INVITE_DECLINE'); ?>
		</button>
	<?php } ?>
	<?php if ($this->booking->state != 5) { ?>
		<button type="button" class="dp-button dp-button-action dp-button-edit"
		        data-href="<?php echo DPCalendarHelperRoute::getBookingFormRoute($this->booking->id); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::EDIT]); ?>
			<?php echo $this->translate($this->booking->state == 3 ? 'COM_DPCALENDAR_PAY' : 'JGLOBAL_EDIT'); ?>
		</button>
	<?php } ?>
	<?php if ($this->booking->state != 5 && $this->booking->price && $this->booking->price != '0.00') { ?>
		<button type="button" class="dp-button dp-button-action dp-button-download"
		        data-href="<?php echo $this->router->route('index.php?option=com_dpcalendar&task=booking.invoice&b_id=' . $this->booking->id); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::DOWNLOAD]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_INVOICE'); ?>
		</button>
	<?php } ?>
	<?php if ($this->booking->state != 5 && (!$this->booking->price || $this->booking->price == '0.00')) { ?>
		<?php $return = '&return=' . base64_encode('index.php?Itemid=' . $this->input->getInt('Itemid')); ?>
		<button type="button" class="dp-button dp-button-action dp-button-delete"
		        data-href="<?php echo $this->router->route('index.php?option=com_dpcalendar&task=bookingform.delete&b_id=' . $this->booking->id . $return); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::DELETE]); ?>
			<?php echo $this->translate('JACTION_DELETE'); ?>
		</button>
	<?php } ?>
	<button type="button" class="dp-button dp-button-print" data-selector=".com-dpcalendar-booking">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PRINTING]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_VIEW_CALENDAR_TOOLBAR_PRINT'); ?>
	</button>
</div>
