<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

if (!$this->qrCodeString) {
	return;
}
?>
<div class="com-dpcalendar-ticket__qrcode dp-qrcode">
	<img src="data:image/png;base64,<?php echo $this->qrCodeString; ?>" class="dp-qrcode__image">
</div>
