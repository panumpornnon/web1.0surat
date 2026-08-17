<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
?>
<div class="com-dpcalendar-ticket__actions dp-button-bar dp-print-hide">
	<?php if ($this->booking->state == 3) { ?>
		<button type="button" class="dp-button dp-button-action dp-button-edit"
				data-href="<?php echo DPCalendarHelperRoute::getBookingFormRoute($this->booking->id); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::EDIT]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_PAY'); ?>
		</button>
	<?php } ?>
	<?php if ($this->booking->state != 5 && $this->booking->price && $this->booking->price != '0.00') { ?>
		<button type="button" class="dp-button dp-button-action dp-button-download"
				data-href="<?php echo $this->router->route('index.php?option=com_dpcalendar&task=booking.invoice&b_id=' . $this->booking->id); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::DOWNLOAD]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_INVOICE'); ?>
		</button>
	<?php } ?>
	<button type="button" class="dp-button dp-button-action dp-button-event"
			data-href="<?php echo $this->router->getEventRoute($this->event->id, $this->event->catid); ?>">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::INFO]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_EVENT'); ?>
	</button>
	<button type="button" class="dp-button dp-button-action dp-button-booking"
			data-href="<?php echo $this->router->getBookingRoute($this->booking); ?>">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::USERS]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_TICKET_FIELD_BOOKING_LABEL'); ?>
	</button>
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
	<?php if ($this->ticket->state != 5) { ?>
		<button type="button" class="dp-button dp-button-action dp-button-edit"
				data-href="<?php echo $this->router->getTicketFormRoute($this->ticket->id); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::EDIT]); ?>
			<?php echo $this->translate('JGLOBAL_EDIT'); ?>
		</button>
		<button type="button" class="dp-button dp-button-action dp-button-edit"
				data-href="<?php echo $this->router->route('index.php?option=com_dpcalendar&task=ticket.pdfdownload&uid=' . $this->ticket->uid); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::DOWNLOAD]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_DOWNLOAD'); ?>
		</button>
	<?php } ?>
	<button type="button" class="dp-button dp-button-print" data-selector=".com-dpcalendar-ticket">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PRINTING]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_VIEW_CALENDAR_TOOLBAR_PRINT'); ?>
	</button>
</div>
