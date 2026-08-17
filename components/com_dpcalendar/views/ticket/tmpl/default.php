<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadStyleFile('dpcalendar/views/ticket/default.css');
?>
<div class="com-dpcalendar-ticket<?php echo $this->pageclass_sfx ? ' com-dpcalendar-ticket-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<?php echo $this->loadTemplate('header'); ?>
	<div class="com-dpcalendar-ticket__event-text">
		<?php echo $this->ticket->displayEvent->beforeDisplayContent; ?>
	</div>
	<?php echo $this->loadTemplate('content'); ?>
	<?php echo $this->loadTemplate('qrcode'); ?>
	<div class="com-dpcalendar-ticket__event-text">
		<?php echo $this->ticket->displayEvent->afterDisplayContent; ?>
	</div>
</div>
