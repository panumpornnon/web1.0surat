<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_CORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_URL);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_FORM);
$this->dpdocument->loadStyleFile('dpcalendar/views/bookingform/default.css');
$this->dpdocument->loadScriptFile('dpcalendar/views/bookingform/default.js');

$this->dpdocument->addScriptOptions(
	'price.url',
	JUri::base() .
	'index.php?option=com_dpcalendar&task=booking.calculateprice&e_id=' .
	(!empty($this->event) ? $this->event->id : 0) . '&b_id=' . (int)$this->bookingId
);

$tmpl = $this->input->getCmd('tmpl') ? '&tmpl=' . $this->input->getCmd('tmpl') : '';
?>
<div class="com-dpcalendar-bookingform<?php echo $this->pageclass_sfx ? ' com-dpcalendar-bookingform-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<form class="com-dpcalendar-bookingform__form dp-form form-validate" method="post" name="adminForm"
		  action="<?php echo $this->router->route('index.php?option=com_dpcalendar&view=bookingform&b_id=' . (int)$this->bookingId . $tmpl); ?>">
		<?php echo $this->layoutHelper->renderLayout('block.loader', $this->displayData); ?>
		<?php echo $this->loadTemplate('header'); ?>
		<?php echo $this->loadTemplate('info_text'); ?>
		<?php echo $this->loadTemplate('events'); ?>
		<?php echo $this->loadTemplate('fields'); ?>
		<?php echo $this->loadTemplate('payment'); ?>
		<?php echo $this->loadTemplate('footer'); ?>
		<input type="hidden" name="task" class="dp-input dp-input-hidden">
		<input type="hidden" name="return" value="<?php echo $this->returnPage; ?>" class="dp-input dp-input-hidden">
		<input type="hidden" name="tmpl" value="<?php echo $this->input->get('tmpl'); ?>" class="dp-input dp-input-hidden">
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
