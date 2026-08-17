<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

?>
<div class="com-dpcalendar-booking__order">
	<div class="com-dpcalendar-booking__order-text"><?php echo $this->orderText; ?></div>
	<div class="com-dpcalendar-booking__plugin-text">
		<?php echo \DPCalendar\Helper\Booking::getPaymentStatementFromPlugin($this->booking, $this->params); ?>
	</div>
</div>
