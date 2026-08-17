<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

use Joomla\Registry\Registry;

if (!JLoader::import('components.com_dpcalendar.helpers.dpcalendar', JPATH_ADMINISTRATOR)) {
	return;
}

$document     = new \DPCalendar\HTML\Document\HtmlDocument();
$dateHelper   = new \DPCalendar\Helper\DateHelper();
$layoutHelper = new \DPCalendar\Helper\LayoutHelper();
$userHelper   = new \DPCalendar\Helper\UserHelper();
$router       = new \DPCalendar\Router\Router();
$translator   = new \DPCalendar\Translator\Translator();
$input        = $app->input;

// The display data with some common helpers for the JLayouts
$displayData = [
	'document'     => $document,
	'layoutHelper' => $layoutHelper,
	'userHelper'   => $userHelper,
	'dateHelper'   => $dateHelper,
	'translator'   => $translator,
	'router'       => $router,
	'params'       => $params,
	'format'       => $params->get('date_format', 'm.d.Y')
];

JFactory::getLanguage()->load('com_dpcalendar', JPATH_ADMINISTRATOR . '/components/com_dpcalendar');

$state = new Registry();

$context = 'com_dpcalendar.map.';

$state->set('filter.search', $app->getUserStateFromRequest($context . 'search', 'search'));
$state->set('filter.location', $app->getUserStateFromRequest($context . 'location', 'location'));
$state->set('filter.radius', $app->getUserStateFromRequest($context . 'radius', 'radius', $params->get('radius', 20)));
$state->set('filter.length-type', $app->getUserStateFromRequest($context . 'length-type', 'length-type', $params->get('length_type', 'mile')));

$startDate = $app->getUserStateFromRequest($context . 'start-date', 'start-date');
if ($startDate) {
	$startDate = $dateHelper->getDate($startDate, true);
}

$endDate = $app->getUserStateFromRequest($context . 'end-date', 'end-date');
if ($endDate) {
	$endDate = $dateHelper->getDate($endDate, true);
}

require JModuleHelper::getLayoutPath('mod_dpcalendar_map', $params->get('layout', 'default'));
