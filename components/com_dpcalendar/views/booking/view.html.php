<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

class DPCalendarViewBooking extends \DPCalendar\View\BaseView
{

	public function display($tpl = null)
	{
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/files/');
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/models');
		$model = JModelLegacy::getInstance('Booking', 'DPCalendarModel');
		$this->setModel($model, true);

		return parent::display($tpl);
	}

	public function init()
	{
		$app = $this->app;

		if ($this->getLayout() == 'cancel') {
			return parent::init();
		}

		if (in_array($this->getLayout(), array('pay', 'order', 'complete'))) {
			JPluginHelper::importPlugin('dpcalendarpay');

			$this->booking = $this->get('Item');

			if ($this->booking->id == null) {
				$this->setError(JText::_('JERROR_ALERTNOAUTHOR'));

				return false;
			}

			$this->plugin = $app->input->get('type') ?: $this->booking->processor;

			if ($this->getLayout() == 'order') {
				$message = JHTML::_('content.prepare', $this->translate($this->params->get('ordertext')));

				// The vars for the message
				$vars                   = (array)$this->booking;
				$vars['currency']       = $this->params->get('currency', 'USD');
				$vars['currencySymbol'] = $this->params->get('currency_symbol', '$');
				$this->orderText        = DPCalendarHelper::renderEvents(array(), $message, $this->params, $vars);
			}
		} else {
			$this->booking = $this->getModel()->getItem(array('uid' => $app->input->get('uid')));

			if (!$this->booking || $this->booking->id == null) {
				$user = JFactory::getUser();
				if ($user->guest) {
					$this->app->redirect(
						JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode(JUri::getInstance())),
						JText::_('COM_DPCALENDAR_NOT_LOGGED_IN'), 'warning'
					);

					return false;
				}

				$this->setError(JText::_('JERROR_ALERTNOAUTHOR'));

				return false;
			}
		}

		// Load the language of the payment plugin
		$plugin = JPluginHelper::getPlugin('dpcalendarpay', $this->booking->processor);
		if ($plugin) {
			JFactory::getLanguage()->load('plg_dpcalendarpay_' . $this->booking->processor,
				JPATH_PLUGINS . '/dpcalendarpay/' . $this->booking->processor);
		}

		// Get the tickets of the booking
		$tickets = $this->getModel()->getTickets($this->booking->id);

		// Add some required variables to the display data
		$this->displayData['booking'] = $this->booking;
		$this->displayData['tickets'] = $tickets;

		// Initialise the amount of tickets
		$this->booking->amount_tickets = 0;
		$this->booking->amount_options = 0;

		// Some data required by the sub layouts
		$this->tickets          = [];
		$this->eventOptions     = [];
		$this->ticketFormFields = [];
		$this->captchaField     = null;
		$orderedOptions         = $this->booking->options ? explode(',', $this->booking->options) : [];
		foreach ($tickets as $ticket) {
			// If the ticket belongs to this booking, increase the counter
			if ($ticket->booking_id == $this->booking->id) {
				$this->booking->amount_tickets++;
			}

			// Try to find the label of the ticket type
			$ticket->price_label = '';
			if ($ticket->event_prices && $ticket->price) {
				$ticket->event_prices = json_decode($ticket->event_prices);

				if (key_exists($ticket->type, $ticket->event_prices->label) && $ticket->event_prices->label[$ticket->type]) {
					$ticket->price_label = $ticket->event_prices->label[$ticket->type];
				}
			}

			// The form of the ticket
			$ticketForm = JModelLegacy::getInstance('Ticket', 'DPCalendarModel', ['ignore_request' => true])->getForm();

			// JForm is caching the forms ba name only instead of name and options
			$p = new ReflectionProperty(JForm::class, 'options');
			$p->setAccessible(true);
			$o            = $p->getValue($ticketForm);
			$o['control'] = 'ticket-' . $ticket->id;
			$p->setValue($ticketForm, $o);

			// Prepare the form
			$ticketForm->setFieldAttribute('id', 'type', 'hidden');
			$ticketForm->bind($ticket);
			$fields = $ticketForm->getFieldset();

			// Remove not needed fields
			foreach ($fields as $index => $field) {
				if (in_array($field->fieldname, ['remind_type', 'remind_time', 'state', 'seat', 'public'])) {
					unset($fields[$index]);
				}

				if ($field->fieldname == 'captcha') {
					$this->captchaField = $field;
					unset($fields[$index]);
				}
			}

			// Sort the fields
			\DPCalendar\Helper\DPCalendarHelper::sortFields($fields, $this->params->get('ticket_form_fields_order_', new stdClass()));
			$this->ticketFormFields[$ticket->id] = $fields;

			// Group the tickets by event
			if (!array_key_exists($ticket->event_id, $this->tickets)) {
				$this->tickets[$ticket->event_id] = [];
			}
			$this->tickets[$ticket->event_id][] = $ticket;

			if (!$ticket->event_options) {
				continue;
			}

			// Prepare the options
			foreach (json_decode($ticket->event_options) as $key => $option) {
				$key = preg_replace('/\D/', '', $key);

				foreach ($orderedOptions as $o) {
					list($eventId, $type, $amount) = explode('-', $o);

					if ($eventId != $ticket->event_id || $type != $key || !empty($this->eventOptions[$eventId][$type])) {
						continue;
					}

					if (!array_key_exists($eventId, $this->eventOptions)) {
						$this->eventOptions[$eventId] = [];
					}
					$this->eventOptions[$eventId][$type] = ['price' => $option->price, 'label' => $option->label, 'amount' => $amount];
					$this->booking->amount_options       += $amount;
				}
			}
		}

		// Prepare the booking through Joomla events
		$this->booking->text = '';
		$this->app->triggerEvent('onContentPrepare', ['com_dpcalendar.booking', &$this->booking, &$this->params, 0]);

		$this->booking->displayEvent                       = new stdClass();
		$results                                           = $this->app->triggerEvent(
			'onContentBeforeDisplay',
			['com_dpcalendar.booking', &$this->booking, &$this->params, 0]
		);
		$this->booking->displayEvent->beforeDisplayContent = trim(implode("\n", $results));

		$results                                          = $this->app->triggerEvent(
			'onContentAfterDisplay',
			['com_dpcalendar.booking', &$this->booking, &$this->params, 0]
		);
		$this->booking->displayEvent->afterDisplayContent = trim(implode("\n", $results));

		// Set up the fields
		$this->bookingFields   = [];
		$this->bookingFields[] = (object)array('id' => 'name', 'name' => 'name');
		$this->bookingFields[] = (object)array('id' => 'email', 'name' => 'email');
		$this->bookingFields[] = (object)array('id' => 'telephone', 'name' => 'telephone');
		$this->bookingFields[] = (object)array('id' => 'country', 'name' => 'country', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_COUNTRY_LABEL');
		$this->bookingFields[] = (object)array(
			'id'    => 'province',
			'name'  => 'province',
			'label' => 'COM_DPCALENDAR_LOCATION_FIELD_PROVINCE_LABEL'
		);
		$this->bookingFields[] = (object)array('id' => 'city', 'name' => 'city', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_CITY_LABEL');
		$this->bookingFields[] = (object)array('id' => 'zip', 'name' => 'zip', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_ZIP_LABEL');
		$this->bookingFields[] = (object)array('id' => 'street', 'name' => 'street', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_STREET_LABEL');
		$this->bookingFields[] = (object)array('id' => 'number', 'name' => 'number', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_NUMBER_LABEL');

		$this->bookingFields = array_merge($this->bookingFields, $this->booking->jcfields);

		// Sort the fields
		\DPCalendar\Helper\DPCalendarHelper::sortFields($this->bookingFields, $this->params->get('booking_fields_order', new stdClass()));

		// Prepare the booking fields
		foreach ($this->bookingFields as $key => $field) {
			if (!$this->params->get('booking_show_' . $field->name, 1)) {
				unset($this->bookingFields[$key]);
				continue;
			}

			$label = 'COM_DPCALENDAR_BOOKING_FIELD_' . strtoupper($field->name) . '_LABEL';

			if (isset($field->label)) {
				$label = $field->label;
			}

			$content = '';
			if (property_exists($this->booking, $field->name)) {
				$content = $this->booking->{$field->name};
			}
			if (property_exists($field, 'value')) {
				$content = $field->value;
			}

			if (!$content) {
				unset($this->bookingFields[$key]);
				continue;
			}

			$field->dpDisplayLabel   = $label;
			$field->dpDisplayContent = $content;
		}

		return parent::init();
	}
}
