<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

?>
<div class="com-dpcalendar-booking__ticket-actions dp-button-bar dp-print-hide">
	<button type="button" class="dp-button dp-button-save" data-task="saveall">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::OK]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_ORDER_SAVE_TICKETS'); ?>
	</button>
	<button type="button" class="dp-button dp-button-clear">
		<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::DELETE]); ?>
		<?php echo $this->translate('COM_DPCALENDAR_CLEAR'); ?>
	</button>
</div>
