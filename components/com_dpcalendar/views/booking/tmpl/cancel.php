<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadStyleFile('dpcalendar/views/booking/cancel.css');
?>
<div class="com-dpcalendar-booking com-dpcalendar-booking-cancel<?php echo $this->pageclass_sfx ? ' com-dpcalendar-booking-' . $this->pageclass_sfx : ''; ?>">
	<h3 class="dp-heading"><?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_MESSAGE_SORRY'); ?></h3>
	<div class="com-dpcalendar-booking__text">
		<?php echo JHTML::_('content.prepare', JText::_($this->params->get('canceltext'))); ?>
	</div>
</div>
