<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

class DPCalendarViewBookingForm extends \DPCalendar\View\BaseView
{
	public function display($tpl = null)
	{
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/models');
		$model = JModelLegacy::getInstance('Booking', 'DPCalendarModel');
		$this->setModel($model, true);

		return parent::display($tpl);
	}

	public function init()
	{
		$eventId       = $this->input->getInt('e_id', 0);
		$this->booking = $this->get('Item');

		// If invalid data, then fail
		if (!$eventId && !$this->booking->id) {
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$this->event = $this->getModel()->getEvent($eventId);
		if ($this->event && !$this->event->plugintype) {
			$this->event->plugintype = 0;
		}

		// If no event found, then fail
		if (!$this->event && !$this->booking->id) {
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$this->form = $this->getModel()->getForm(['event_id' => [$this->event->id => []]]);
		$this->form->removeField('processor');
		$this->returnPage = $this->get('ReturnPage');
		$this->tickets    = [];

		$this->app->setUserState('payment_return', $this->returnPage);

		if (!empty($this->booking) && isset($this->booking->id)) {
			$this->form->bind($this->booking);
			$this->tickets = $this->getModel()->getTickets($this->booking->id);
		}

		$this->bookingId = $this->booking && $this->booking->id ? $this->booking->id : 0;

		$this->events = \DPCalendar\Helper\Booking::getSeriesEvents($this->event);

		// If no series events are found add the single event
		if ($this->event && !$this->events) {
			$this->events = array($this->event);
		}

		// Add payment info block
		if ($this->bookingId && $this->booking->state == 3) {
			$this->app->enqueueMessage($this->translate('COM_DPCALENDAR_LAYOUT_BOOKING_STATE_NEEDS_PAYMENT_INFORMATION'));
		}

		// Check if payment is needed
		$this->needsPayment = false;
		if ($this->bookingId && $this->booking->state == 4) {
			$this->app->enqueueMessage($this->translate('COM_DPCALENDAR_LAYOUT_BOOKING_STATE_ON_HOLD_INFORMATION'));
			$this->needsPayment = true;
		} else {
			// Calculate if a payment is needed
			$this->needsPayment = \DPCalendar\Helper\Booking::paymentRequired($this->event);
			foreach ($this->events as $s) {
				if (\DPCalendar\Helper\Booking::paymentRequired($s)) {
					$this->needsPayment = true;
					break;
				}
			}
		}

		JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');
		JLoader::import('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_BASE . '/components/com_content/models', 'ContentModel');

		if (\DPCalendar\Helper\DPCalendarHelper::isJoomlaVersion('4', '>=')) {
			$model = JFactory::getApplication()->bootComponent('com_content')->createMVCFactory(JFactory::getApplication())->createModel('Article',
				'Site');
		} else {
			$model = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));

			// If the article is not found an error is thrown we need to hold the old error handler
			$errorHandler = JError::getErrorHandling(E_ERROR);
			// Ignoring all errors
			JError::setErrorHandling(E_ERROR, 'ignore');
		}
		$model->setState('params', new \Joomla\Registry\Registry());
		$model->setState('filter.published', 1);

		$this->terms      = [];
		$activatedPlugins = [];
		foreach ($this->events as $e) {
			foreach ((array)$e->plugintype as $pluginName) {
				$activatedPlugins[$pluginName] = true;
			}

			$price = $e->price;
			if (!$price || !$price->value) {
				$e->price = new JObject(array(
					'value'       => array('0'),
					'label'       => [$this->translate('COM_DPCALENDAR_TICKET')],
					'description' => array('')
				));
			}

			$e->ticket_count = $e->max_tickets ? $e->max_tickets : 1;

			if ($e->capacity !== null && $e->ticket_count > ($e->capacity - $e->capacity_used)) {
				$e->ticket_count = $e->capacity - $e->capacity_used;
			}

			$tickets = JModelLegacy::getInstance('Adminevent', 'DPCalendarModel')->getTickets($e->id);

			foreach ($tickets as $ticket) {
				if ($ticket->email == $this->user->email) {
					$e->ticket_count--;
				}
			}

			$e->ticket_count = max($e->ticket_count, 0);

			if ($e->terms && !$this->bookingId) {
				// Fetching the article
				$article = $model->getItem($e->terms);

				if (!$article instanceof Exception && !array_key_exists($article->id, $this->terms)) {
					$article->dp_terms_link    = $this->router->route(
						ContentHelperRoute::getArticleRoute(
							$article->id . ':' . $article->alias,
							$article->catid,
							$article->language
						)
					);
					$this->terms[$article->id] = $article;
				}
			}
		}

		if (\DPCalendar\Helper\DPCalendarHelper::isJoomlaVersion('4', '<')) {
			// Restore the old error handler
			JError::setErrorHandling(E_ERROR, $errorHandler['mode'], $errorHandler['options']);
		}

		$this->plugins = JPluginHelper::getPlugin('dpcalendarpay');
		foreach ($this->plugins as $key => $plugin) {
			if (key_exists(0, $activatedPlugins) || key_exists($plugin->name, $activatedPlugins)) {
				$this->app->getLanguage()->load(
					'plg_' . $plugin->type . '_' . $plugin->name, JPATH_PLUGINS . '/' . $plugin->type . '/' . $plugin->name
				);

				continue;
			}
			unset($this->plugins[$key]);
		}
	}
}
