<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

if (count($this->events) != 1 || !reset($this->events)->booking_information) {
	return;
}
?>
<div class="com-dpcalendar-bookingform__info-text">
	<?php echo reset($this->events)->booking_information; ?>
</div>
