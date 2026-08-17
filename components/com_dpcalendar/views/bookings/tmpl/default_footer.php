<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

?>
<div class="com-dpcalendar-bookings__footer dp-pagination dp-print-hide pagination">
	<div class="dp-pagination__counter"><?php echo $this->pagination->getPagesCounter(); ?></div>
	<div class="dp-pagination__links"><?php echo $this->pagination->getPagesLinks(); ?></div>
</div>
