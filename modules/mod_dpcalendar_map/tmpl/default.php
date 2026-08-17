<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$document->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$document->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_MAP);
$document->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_AUTOCOMPLETE);
$document->loadScriptFile('dpcalendar/views/map/default.js');
$document->loadStyleFile('default.css', 'mod_dpcalendar_map');

if ($params->get('show_as_popup')) {
	$document->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_MODAL);
}

$translator->translateJS('COM_DPCALENDAR_FIELD_CONFIG_EVENT_LABEL_NO_EVENT_TEXT');
?>
<div class="mod-dpcalendar-map mod-dpcalendar-map-<?php echo $module->id; ?> dp-search-map"
     data-popup="<?php echo $params->get('show_as_popup'); ?>">
	<?php echo $layoutHelper->renderLayout('block.loader', $displayData); ?>
	<form action="index.php?option=com_dpcalendar&view=map&layout=events&format=raw" method="post"
	      class="form-validate noprint mod-dpcalendar-map__form dp-form">
		<?php if ($params->get('show_search', 1)) { ?>
			<div class="mod-dpcalendar-map__search">
				<div class="mod-dpcalendar-map__form-container">
					<div class="mod-dpcalendar-map__text-search">
						<input type="text" name="search" value="<?php echo $state->get('filter.search'); ?>"
						       class="dp-input dp-input-text"
						       placeholder="<?php echo $translator->translate('JGLOBAL_FILTER_LABEL'); ?>">
					</div>
					<div class="mod-dpcalendar-map__date-search">
						<?php $displayData['title'] = $translator->translate('MOD_DPCALENDAR_MAP_START_DATE'); ?>
						<?php $displayData['name'] = 'start-date'; ?>
						<?php $displayData['date'] = $startDate; ?>
						<?php echo $layoutHelper->renderLayout('block.datepicker', $displayData); ?>
						<?php $displayData['title'] = $translator->translate('MOD_DPCALENDAR_MAP_END_DATE'); ?>
						<?php $displayData['name'] = 'end-date'; ?>
						<?php $displayData['date'] = $endDate; ?>
						<?php echo $layoutHelper->renderLayout('block.datepicker', $displayData); ?>
					</div>
				</div>
				<div class="mod-dpcalendar-map__form-container">
					<div class="mod-dpcalendar-map__location-search">
						<input type="text" name="location" value="<?php echo $state->get('filter.location'); ?>"
						       class="dp-input dp-input-text dp-input_location" autocomplete="off"
						       placeholder="<?php echo $translator->translate('MOD_DPCALENDAR_MAP_ADDRESS'); ?>">
					</div>
					<div class="mod-dpcalendar-map__radius-search">
						<?php $radius = $state->get('filter.radius', 50); ?>
						<select name="radius" class="dp-input dp-input-select">
							<option value="5"<?php echo $radius == 5 ? ' selected' : ''; ?>>5</option>
							<option value="10"<?php echo $radius == 10 ? ' selected' : ''; ?>>10</option>
							<option value="20"<?php echo $radius == 20 ? ' selected' : ''; ?>>20</option>
							<option value="50"<?php echo $radius == 50 ? ' selected' : ''; ?>>50</option>
							<option value="100"<?php echo $radius == 100 ? ' selected' : ''; ?>>100</option>
							<option value="500"<?php echo $radius == 500 ? ' selected' : ''; ?>>500</option>
							<option value="1000"<?php echo $radius == 1000 ? ' selected' : ''; ?>>1000</option>
							<option value="-1"<?php echo $radius == '-1' ? ' selected' : ''; ?>><?php echo $translator->translate('JALL'); ?></option>
						</select>
						<?php $length = $state->get('filter.length-type', 'm'); ?>
						<select name="length-type" class="dp-input dp-input-select">
							<option value="m"<?php echo $length == 'm' ? ' selected' : ''; ?>>
								<?php echo $translator->translate('MOD_DPCALENDAR_MAP_LENGTH_TYPE_KILOMETER'); ?>
							</option>
							<option value="mile"<?php echo $length == 'mile' ? ' selected' : ''; ?>>
								<?php echo $translator->translate('MOD_DPCALENDAR_MAP_LENGTH_TYPE_MILE'); ?>
							</option>
						</select>
					</div>
				</div>
				<div class="mod-dpcalendar-map__button-bar dp-button-bar">
					<button class="dp-button dp-button-current-location" type="button">
						<?php echo $layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::LOCATION]); ?>
						<?php echo $translator->translate('MOD_DPCALENDAR_MAP_CURRENT_LOCATION'); ?>
					</button>
					<button class="dp-button dp-button-search" type="button">
						<?php echo $layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::OK]); ?>
						<?php echo $translator->translate('JSEARCH_FILTER'); ?>
					</button>
					<button class="dp-button dp-button-clear" type="button">
						<?php echo $layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::CANCEL]); ?>
						<?php echo $translator->translate('JCLEAR'); ?>
					</button>
				</div>
			</div>
		<?php } else { ?>
			<input type="hidden" name="radius" value="<?php echo $state->get('filter.radius', 50); ?>" class="dp-input dp-input-hidden">
			<input type="hidden" name="length-type" value="<?php echo $state->get('filter.length-type', 'm'); ?>" class="dp-input dp-input-hidden">
		<?php } ?>
		<input type="hidden" name="Itemid" value="<?php echo $input->getInt('Itemid'); ?>" class="dp-input dp-input-hidden">
		<input type="hidden" name="module-id" value="<?php echo $module->id; ?>" class="dp-input dp-input-hidden">
	</form>
	<div class="mod-dpcalendar-map__map dp-map"
	     data-width="<?php echo $params->get('width', '100%'); ?>"
	     data-height="<?php echo $params->get('height', '300px'); ?>"
	     data-zoom="<?php echo $params->get('zoom', 4); ?>"
	     data-latitude="<?php echo $params->get('lat', 47); ?>"
	     data-longitude="<?php echo $params->get('long', 4); ?>">
	</div>
</div>
