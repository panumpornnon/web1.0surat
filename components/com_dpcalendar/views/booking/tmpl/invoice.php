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
$this->displayData['booking'] = $this->booking;
$this->displayData['tickets'] = call_user_func_array('array_merge', $this->tickets);
?>
<div class="com-dpcalendar-booking com-dpcalendar-booking-invoice<?php echo $this->pageclass_sfx ? ' com-dpcalendar-booking-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->layoutHelper->renderLayout('booking.invoice', $this->displayData); ?>
</div>
