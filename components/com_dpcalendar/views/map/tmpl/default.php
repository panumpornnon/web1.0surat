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
$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_MAP);
if ($this->params->get('map_show_event_as_popup')) {
	$this->dpdocument->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_MODAL);
}
$this->dpdocument->loadScriptFile('dpcalendar/views/map/default.js');
$this->dpdocument->loadStyleFile('dpcalendar/views/map/default.css');

$this->translator->translateJS('COM_DPCALENDAR_FIELD_CONFIG_EVENT_LABEL_NO_EVENT_TEXT');
?>
<div class="com-dpcalendar-map dp-search-map<?php echo $this->pageclass_sfx ? ' com-dpcalendar-map-' . $this->pageclass_sfx : ''; ?>"
     data-popup="<?php echo $this->params->get('map_show_event_as_popup'); ?>"
     data-popupwidth="<?php echo $this->params->get('map_popup_width'); ?>"
     data-popupheight="<?php echo $this->params->get('map_popup_height', 500); ?>">
	<?php echo $this->layoutHelper->renderLayout('block.timezone', $this->displayData); ?>
	<?php echo $this->loadTemplate('heading'); ?>
	<div class="com-dpcalendar-map__loader">
		<?php echo $this->layoutHelper->renderLayout('block.loader', $this->displayData); ?>
	</div>
	<?php echo $this->loadTemplate('form'); ?>
	<?php echo $this->loadTemplate('map'); ?>
</div>
