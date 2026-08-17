<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_FORM);
$this->dpdocument->loadStyleFile('dpcalendar/views/booking/order.css');
$this->dpdocument->loadScriptFile('dpcalendar/views/booking/order.js');
?>
<div class="com-dpcalendar-booking com-dpcalendar-booking-order<?php echo $this->pageclass_sfx ? ' com-dpcalendar-booking-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->loadTemplate('heading'); ?>
	<?php echo $this->loadTemplate('header'); ?>
	<h3 class="com-dpcalendar-booking__heading dp-heading">
		<?php echo $this->translate('COM_DPCALENDAR_VIEW_BOOKING_MESSAGE_THANKYOU'); ?>
	</h3>
	<?php echo $this->loadTemplate('content'); ?>
	<?php echo $this->loadTemplate('tickets'); ?>
	<div class="com-dpcalendar-booking__registration">
		<?php echo $this->layoutHelper->renderLayout('booking.register', $this->displayData); ?>
	</div>
</div>
