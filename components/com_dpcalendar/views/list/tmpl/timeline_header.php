<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
?>
<div class="com-dpcalendar-timeline__actions dp-button-bar dp-print-hide">
	<div class="dp-button-bar__navigation">
		<button type="button" class="dp-button dp-button-action dp-button-prev" data-href="<?php echo $this->prevLink; ?>"
				aria-label="<?php echo $this->translate('COM_DPCALENDAR_PREVIOUS'); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::BACK]); ?>
		</button>
		<button type="button" class="dp-button dp-button-action dp-button-next" data-href="<?php echo $this->nextLink; ?>"
				aria-label="<?php echo $this->translate('COM_DPCALENDAR_NEXT'); ?>">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::NEXT]); ?>
		</button>
	</div>
	<div class="dp-button-bar__title dp-title">
		<span class="dp-title__start"><?php echo $this->startDate->format($this->params->get('list_title_format', 'm.d.Y'), true); ?></span>
		<span class="dp-title__separator"> - </span>
		<span class="dp-title__end"><?php echo $this->endDate->format($this->params->get('list_title_format', 'm.d.Y'), true); ?></span>
	</div>
	<div class="dp-button-bar__actions">
		<?php if (DPCalendarHelper::canCreateEvent()) { ?>
			<button type="button" class="dp-button dp-button-action dp-button-create"
					data-href="<?php echo $this->router->getEventFormRoute(0, $this->return); ?>">
				<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PLUS]); ?>
				<?php echo $this->translate('JACTION_CREATE'); ?>
			</button>
		<?php } ?>
		<button type="button" class="dp-button dp-button-print" data-selector=".com-dpcalendar-timeline">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::PRINTING]); ?>
			<?php echo $this->translate('COM_DPCALENDAR_VIEW_CALENDAR_TOOLBAR_PRINT'); ?>
		</button>
		<button type="button" class="dp-button dp-button-search">
			<?php echo $this->layoutHelper->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::SEARCH]); ?>
			<?php echo $this->translate('JSEARCH_FILTER'); ?>
		</button>
	</div>
</div>
