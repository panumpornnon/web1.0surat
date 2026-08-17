<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadStyleFile('dpcalendar/views/booking/default.css');
?>
<div class="com-dpcalendar-booking com-dpcalendar-booking-default<?php echo $this->pageclass_sfx ? ' com-dpcalendar-booking-' . $this->pageclass_sfx : ''; ?> dp-grid">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<?php echo $this->loadTemplate('header'); ?>
	<div class="com-dpcalendar-booking__event-text">
		<?php echo $this->booking->displayEvent->beforeDisplayContent; ?>
	</div>
	<?php echo $this->loadTemplate('content'); ?>
	<?php echo $this->loadTemplate('tickets'); ?>
	<div class="com-dpcalendar-booking__event-text">
		<?php echo $this->booking->displayEvent->afterDisplayContent; ?>
	</div>
	<div class="com-dpcalendar-booking__registration">
		<?php echo $this->layoutHelper->renderLayout('booking.register', $this->displayData); ?>
	</div>
</div>
