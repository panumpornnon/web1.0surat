<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_SELECT);
$this->dpdocument->loadStyleFile('dpcalendar/views/profile/default.css');
$this->dpdocument->loadScriptFile('dpcalendar/views/profile/default.js');

$this->translator->translateJS('COM_DPCALENDAR_CONFIRM_DELETE');
$this->translator->translateJS('COM_DPCALENDAR_VIEW_DAVCALENDAR_NONE_SELECTED_LABEL');
?>
<div class="com-dpcalendar-profile<?php echo $this->pageclass_sfx ? ' com-dpcalendar-profile-' . $this->pageclass_sfx : ''; ?>">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<?php echo $this->loadTemplate('sharing'); ?>
	<?php echo $this->loadTemplate('title'); ?>
	<?php echo $this->loadTemplate('form'); ?>
	<?php echo $this->loadTemplate('calendars'); ?>
	<?php echo $this->loadTemplate('footer'); ?>
	<?php echo $this->loadTemplate('events'); ?>
</div>
