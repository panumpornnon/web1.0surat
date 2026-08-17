<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

JLoader::import('components.com_dpcalendar.helpers.schema', JPATH_ADMINISTRATOR);

class DPCalendarViewList extends \DPCalendar\View\BaseView
{

	protected $items = array();
	protected $increment = null;

	public function display($tpl = null)
	{
		$model = JModelLegacy::getInstance('Events', 'DPCalendarModel');
		$this->setModel($model, true);

		parent::display($tpl);
	}

	protected function init()
	{
		JFactory::getLanguage()->load('com_dpcalendar', JPATH_ADMINISTRATOR . '/components/com_dpcalendar');

		$this->displayData['format'] = $this->params->get('event_form_date_format', 'm.d.Y');

		$this->return = $this->input->getInt('Itemid', null) ? 'index.php?Itemid=' . $this->input->getInt('Itemid', null) : null;

		$context         = 'com_dpcalendar.listview.filter.';
		$this->params    = $this->state->params;
		$this->increment = $this->params->get('list_increment', '1 month');
		$dateStart       = DPCalendarHelper::getDate($this->params->get('date_start', $this->state->get('list.start-date')));

		$dateEnd = $this->state->get('list.end-date');
		if (!empty($dateEnd)) {
			$dateEnd = DPCalendarHelper::getDate($dateEnd);
		}

		$this->overrideStartDate = $this->app->getUserStateFromRequest($context . 'start', 'start-date');
		if (!empty($this->overrideStartDate)) {
			$dateStart = DPCalendarHelper::getDateFromString($this->overrideStartDate, null, true);
		}
		$this->overrideEndDate = $this->app->getUserStateFromRequest($context . 'end', 'end-date');
		if (!empty($this->overrideEndDate)) {
			$dateEnd = DPCalendarHelper::getDateFromString($this->overrideEndDate, null, true);
		}

		if (empty($dateEnd)) {
			$dateEnd = clone $dateStart;
			$dateEnd->modify('+ ' . $this->increment);
		}

		$dateStart->setTimezone(new DateTimeZone('UTC'));
		$dateEnd->setTimezone(new DateTimeZone('UTC'));

		// Only set time when we are during the day.
		// It will prevent day shifts.
		if ($dateStart->format('H:i') != '00:00') {
			$dateStart->setTime(0, 0, 0);
			$dateEnd->setTime(0, 0, 0);
		}

		// End date is exclusive, so show day before
		$dateEnd->modify('-1 second');

		$this->state->set('list.start-date', $dateStart);
		$this->state->set('list.end-date', $dateEnd);

		$this->startDate = clone $dateStart;
		$this->endDate   = clone $dateEnd;

		// The start value
		$start = clone $dateStart;
		$start->modify('+ ' . $this->increment);

		// The end value
		$end = clone $dateEnd;
		$end->modify('+ ' . $this->increment);

		// The link to the next page
		$this->nextLink = 'index.php?option=com_dpcalendar&view=list&Itemid=';
		$this->nextLink .= $this->input->getInt('Itemid') . '&date-start=' . $start->format('U') . '&date-end=' . $end->format('U');
		$this->nextLink = $this->router->route($this->nextLink);

		// Modify the start for the prev link
		$start->modify('- ' . $this->increment);
		$start->modify('- ' . $this->increment);

		// Modify the end for the prev link
		$end->modify('- ' . $this->increment);
		$end->modify('- ' . $this->increment);

		// The link to the prev page
		$this->prevLink = 'index.php?option=com_dpcalendar&view=list&Itemid=';
		$this->prevLink .= $this->input->getInt('Itemid') . '&date-start=' . $start->format('U') . '&date-end=' . $end->format('U');
		$this->prevLink = $this->router->route($this->prevLink);

		$model = $this->getModel();

		// Initialise variables
		$model->setState('category.id', $this->app->getParams()->get('ids'));
		$model->setState('category.recursive', true);
		$model->setState('filter.featured', $this->params->get('list_filter_featured', '2') == '1');
		$model->setState('filter.my', $this->params->get('show_my_only_list'));

		$now = DPCalendarHelper::getDate();
		$now->setTime(0, 0, 0);
		$model->setState('list.direction', $dateEnd->format('U') < $now->format('U') ? 'desc' : 'asc');
		$model->setState('list.limit', 100000);

		// Location filters
		if ($location = $this->app->getUserStateFromRequest($context . 'location', 'location')) {
			$model->setState('filter.location', \DPCalendar\Helper\Location::get($location, false));
			$model->setState('filter.radius', $this->app->getUserStateFromRequest($context . 'radius', 'radius'));
			$model->setState('filter.length-type', $this->app->getUserStateFromRequest($context . 'length-type', 'length-type'));
		}

		$this->state = $model->getState();

		$items = $this->get('Items');

		if ($items === false) {
			throw new Exception(JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}

		foreach ($items as $event) {
			$event->text = $event->description;
			JPluginHelper::importPlugin('content');
			$this->app->triggerEvent('onContentPrepare', array('com_dpcalendar.event', &$event, &$event->params, 0));
			$event->description = $event->text;

			$desc = JHTML::_('content.prepare', $event->description);
			if ($desc && $this->params->get('list_description_length', null) !== null) {
				$descTruncated = JHtmlString::truncateComplex($desc, $this->params->get('list_description_length', null));
				if ($desc != $descTruncated) {
					$event->alternative_readmore = JText::_('COM_DPCALENDAR_READ_MORE');

					$desc = $this->layoutHelper->renderLayout(
						'joomla.content.readmore',
						[
							'item'   => $event,
							'params' => new \Joomla\Registry\Registry(['access-view' => true]),
							'link'   => $this->router->getEventRoute($event->id, $event->catid)
						]
					);

					$desc = $descTruncated . $desc;
				}
			}

			$event->truncatedDescription = $desc;
		}
		$this->events = $items;
	}
}
