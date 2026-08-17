<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadStyleFile('dpcalendar/views/list/default.css');
$this->dpdocument->loadScriptFile('dpcalendar/views/list/default.js');
?>
<div class="com-dpcalendar-list dp-locations<?php echo $this->pageclass_sfx ? ' com-dpcalendar-list-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<div class="com-dpcalendar-list__custom-text">
		<?php echo JHtml::_('content.prepare', $this->translate($this->params->get('list_textbefore'))); ?>
	</div>
	<?php echo $this->loadTemplate('map'); ?>
	<?php echo $this->loadTemplate('header'); ?>
	<?php echo $this->loadTemplate('form'); ?>
	<?php echo $this->loadTemplate('events'); ?>
	<div class="com-dpcalendar-list__custom-text">
		<?php echo JHtml::_('content.prepare', $this->translate($this->params->get('list_textafter'))); ?>
	</div>
</div>
