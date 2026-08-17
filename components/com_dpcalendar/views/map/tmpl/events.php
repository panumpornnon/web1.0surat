<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

JFactory::getDocument()->setMimeEncoding('application/json');

$data = array();
foreach ($this->items as $event) {
	$displayData          = $this->displayData;
	$displayData['event'] = $event;
	$description          = trim($this->layoutHelper->renderLayout('event.tooltip', $displayData));
	$description          = \DPCalendar\Helper\DPCalendarHelper::fixImageLinks($description);

	$locations = array();
	if (!empty($event->locations)) {
		foreach ($event->locations as $location) {
			$locations[] = array(
				'location'  => \DPCalendar\Helper\Location::format($location),
				'latitude'  => $location->latitude,
				'longitude' => $location->longitude
			);
		}
	}
	$data[] = array(
		'id'          => $event->id,
		'title'       => htmlspecialchars_decode($event->title),
		'start'       => DPCalendarHelper::getDate($event->start_date, $event->all_day)->format('c', true),
		'end'         => DPCalendarHelper::getDate($event->end_date, $event->all_day)->format('c', true),
		'url'         => DPCalendarHelperRoute::getEventRoute($event->id, $event->catid),
		'editable'    => JFactory::getUser()->authorise('core.edit', 'com_dpcalendar.category.' . $event->catid),
		'color'       => '#' . $event->color,
		'allDay'      => (bool)$event->all_day,
		'description' => $description,
		'location'    => $locations
	);
}

$messages = JFactory::getApplication()->getMessageQueue();

// Build the sorted messages list
$lists = array();
if (is_array($messages) && count($messages)) {
	foreach ($messages as $message) {
		if (isset($message['type']) && isset($message['message'])) {
			$lists[$message['type']][] = $message['message'];
		}
	}
}

// Echo the data
ob_clean();
echo json_encode(array('data' => ['events' => $data, 'location' => $this->state->get('filter.location')], 'messages' => $lists));

// Close the request
JFactory::getApplication()->close();
