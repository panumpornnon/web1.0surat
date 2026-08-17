<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadScriptFile('dpcalendar/views/tickets/default.js');
$this->dpdocument->loadStyleFile('dpcalendar/views/tickets/default.css');

if ($this->event) {
	$this->app->enqueueMessage(JText::sprintf('COM_DPCALENDAR_VIEW_TICKETS_SHOW_FROM_EVENT', $this->escape($this->event->title)));
}

// If we have a booking, show an information message
if ($this->booking) {
	$this->app->enqueueMessage(JText::sprintf('COM_DPCALENDAR_VIEW_TICKETS_SHOW_FROM_BOOKING', $this->escape($this->booking->uid)));
}
?>
<div class="com-dpcalendar-tickets<?php echo $this->pageclass_sfx ? ' com-dpcalendar-tickets-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<?php echo $this->loadTemplate('header'); ?>
	<?php echo $this->loadTemplate('content'); ?>
	<?php echo $this->loadTemplate('footer'); ?>
</div>
