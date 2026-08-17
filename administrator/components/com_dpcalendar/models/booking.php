<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

use DPCalendar\Booking\Stages\AdjustCustomFields;
use DPCalendar\Booking\Stages\CollectEventsAndTickets;
use DPCalendar\Booking\Stages\CreateOrUpdateTickets;
use DPCalendar\Booking\Stages\FetchLocationData;
use DPCalendar\Booking\Stages\SendNewBookingMail;
use DPCalendar\Booking\Stages\SendNotificationMail;
use DPCalendar\Booking\Stages\SetupForMail;
use DPCalendar\Booking\Stages\SetupForNew;
use DPCalendar\Booking\Stages\SetupForUpdate;
use Joomla\Utilities\ArrayHelper;
use League\Pipeline\PipelineBuilder;

JLoader::import('joomla.application.component.modeladmin');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/tables');

class DPCalendarModelBooking extends JModelAdmin
{
	private $events = null;

	/**
	 * Saves the given data.
	 * Some special behaviors are done when it is an invite request:
	 * - It sets the state to invited.
	 * - No notifications are sent.
	 * - The created booking is returned.
	 *
	 * {@inheritdoc}
	 *
	 * @see JModelAdmin::save()
	 */
	public function save($data, $invite = false)
	{
		$app = JFactory::getApplication();

		$payload                    = new stdClass();
		$payload->data              = $data;
		$payload->invite            = $invite;
		$payload->eventsWithTickets = [];
		$payload->events            = [];
		$payload->tickets           = [];
		$payload->oldItem           = array_key_exists('id', $data) && $data['id'] ? $this->getItem($payload->data['id']) : null;

		if ($invite) {
			$payload->data['state'] = 5;
		}

		$builder = new PipelineBuilder();
		$builder->add(new CollectEventsAndTickets($this));
		$builder->add(new FetchLocationData());

		if (!$payload->oldItem) {
			$builder->add(new SetupForNew($app, JFactory::getUser()));
		} else {
			$builder->add(new SetupForUpdate($app, JFactory::getUser()));
		}

		try {
			$builder->build()->process($payload);
		} catch (Exception $e) {
			$this->setError($e->getMessage());

			return false;
		}

		$success = parent::save($payload->data);

		if (!$success) {
			return $success;
		}

		// Set up id for payment system
		$id = $this->getState($this->getName() . '.id');
		$app->input->set('b_id', $id);
		JFactory::getSession()->set('booking_id', $id, 'com_dpcalendar');
		$payload->item = $this->getItem();

		$builder = new PipelineBuilder();
		$builder->add(
			new CreateOrUpdateTickets(JModelLegacy::getInstance('Ticket', 'DPCalendarModel', ['ignore_request' => true]), $app)
		);

		if ($invite) {
			$builder->build()->process($payload);

			return $payload->item;
		}

		$builder->add(new AdjustCustomFields());
		$builder->add(new SetupForMail($app));
		$builder->add(new SendNewBookingMail(JFactory::getMailer()));
		$builder->add(new SendNotificationMail(JFactory::getMailer()));

		$builder->build()->process($payload);

		return $success;
	}

	public function delete(&$pks)
	{
		$success = parent::delete($pks);

		if ($success) {
			foreach ((array)$pks as $pk) {
				foreach ($this->getTickets($pk) as $ticket) {
					$model = JModelLegacy::getInstance('Ticket', 'DPCalendarModel');
					$model->delete($ticket->id);
				}
			}
		}

		return $success;
	}

	protected function canEditState($record)
	{
		if (parent::canEditState($record)) {
			return true;
		}

		if (!empty($record->id)) {
			if ($record->user_id == JFactory::getUser()->id) {
				return true;
			} else {
				return false;
			}
		}

		return false;
	}

	protected function canDelete($record)
	{
		if (parent::canDelete($record)) {
			return true;
		}

		if (!empty($record->id)) {
			if ($record->user_id == JFactory::getUser()->id) {
				return true;
			} else {
				return false;
			}
		}

		return false;
	}

	public function getTable($type = 'Booking', $prefix = 'DPCalendarTable', $config = array())
	{
		$table = JTable::getInstance($type, $prefix, $config);
		$table->check();

		return $table;
	}

	public function getForm($data = array(), $loadData = true)
	{
		JForm::addFormPath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/models/forms');

		$form = $this->loadForm('com_dpcalendar.booking', 'booking', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		$item = $this->getItem();

		if (!$this->canEditState($item)) {
			// Disable fields for display.
			$form->setFieldAttribute('state', 'disabled', 'true');
			$form->setFieldAttribute('price', 'disabled', 'true');
		}

		if (!DPCalendarHelper::isCaptchaNeeded()) {
			$form->removeField('captcha');
		}

		if (JFactory::getApplication()->isClient('site')) {
			$form->setFieldAttribute('user_id', 'type', 'hidden');
			$form->setFieldAttribute('id', 'type', 'hidden');

			$form->removeField('latitude');
			$form->removeField('longitude');
			$form->removeField('price');
			$form->removeField('state');
		} else {
			$form->removeField('series');
		}

		$form->removeField('transaction_id');
		$form->removeField('type');
		$form->removeField('payer_email');

		$this->modifyField($form, 'country');
		$this->modifyField($form, 'province');
		$this->modifyField($form, 'city');
		$this->modifyField($form, 'zip');
		$this->modifyField($form, 'street');
		$this->modifyField($form, 'number');
		$this->modifyField($form, 'telephone');

		if (isset($data['event_id'])) {
			// Clear the cache, doggy
			$reflection = new \ReflectionProperty(\FieldsHelper::class, 'fieldsCache');
			$reflection->setAccessible(true);

			foreach ($data['event_id'] as $eventId => $requestData) {
				$event = $this->getEvent($eventId);

				$item->catid = $event->catid;

				$reflection->setValue(null, null);
				$itemFields  = FieldsHelper::getFields('com_dpcalendar.booking', $item);

				$reflection->setValue(null, null);
				foreach (FieldsHelper::getFields('com_dpcalendar.booking') as $field) {
					$has = array_filter(
						$itemFields,
						function ($f) use ($field) {
							return $f->id == $field->id;
						}
					);

					if ($has) {
						continue;
					}

					$form->removeField($field->name, 'com_fields');
				}
				break;
			}
		}

		return $form;
	}

	private function modifyField(JForm $form, $name)
	{
		$params = $this->getState('params');
		if (!$params) {
			$params = JComponentHelper::getParams('com_dpcalendar');

			if (JFactory::getApplication()->isClient('site')) {
				$params = JFactory::getApplication()->getParams();
			}
		}

		$state = $params->get('booking_form_' . $name, 1);
		switch ($state) {
			case 0:
				$form->removeField($name);
				break;
			case 2:
				$form->setFieldAttribute($name, 'required', 'true');
				break;
		}
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_dpcalendar.edit.booking.data', array());
		if (empty($data)) {
			$data = $this->getItem();
		} else {
			$data = ArrayHelper::toObject($data, 'JObject');
		}

		if (!$data) {
			$data     = $this->getTable();
			$data->id = 0;
		}

		// If no booking is found load the form with some old data
		if (!$data->id && !JFactory::getUser()->guest) {
			$this->getDbo()->setQuery('select id from #__dpcalendar_bookings where user_id = ' . JFactory::getUser()->id . ' order by id desc limit 1');
			$row = $this->getDbo()->loadAssoc();
			if ($row) {
				$data           = $this->getItem($row['id']);
				$data->id       = null;
				$data->event_id = null;
				$data->state    = null;
			}
		}

		$this->preprocessData('com_dpcalendar.booking', $data);

		return $data;
	}

	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}

	protected function populateState()
	{
		$app = JFactory::getApplication();

		$pk = $app->input->getInt('b_id');
		$this->setState('booking.id', $pk);
		$this->setState('form.id', $pk);

		$return = $app->input->getVar('return', null, 'default', 'base64');

		if (!JUri::isInternal(base64_decode($return))) {
			$return = null;
		}

		$this->setState('return_page', base64_decode($return));

		$params = JComponentHelper::getParams('com_dpcalendar');

		if ($app->isClient('site')) {
			$params = $app->getParams();
		}
		$this->setState('params', $params);
	}

	/**
	 * Returns the booking id which is assigned to the given user.
	 * If none is assigned it returns false.
	 *
	 * @param array $user
	 *
	 * @return $bookingId
	 */
	public function assign($user)
	{
		$bookingFromSession = JFactory::getSession()->get('booking_id', 0, 'com_dpcalendar');
		if (!$bookingFromSession) {
			return false;
		}

		$u = ArrayHelper::toObject($user);

		$booking = $this->getTable();
		$booking->load($bookingFromSession);
		$booking->user_id = $u->id;
		$booking->store();

		foreach ($this->getTickets($bookingFromSession) as $ticket) {
			$t = $this->getTable('Ticket');
			$t->load($ticket->id);
			$t->user_id = $u->id;
			$t->store();
		}

		JFactory::getSession()->set('booking_id', 0, 'com_dpcalendar');

		return $booking;
	}

	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);

		$user = JFactory::getUser();
		if ($item && !$user->guest && ($user->id == $item->user_id || $user->authorise('core.admin', 'com_dpcalendar'))) {
			return $item;
		}

		$bookingFromSession = JFactory::getSession()->get('booking_id', 0, 'com_dpcalendar');
		if ($item && $user->guest && $bookingFromSession == $item->id) {
			return $item;
		}

		return null;
	}

	public function getEvent($eventId = null, $force = false)
	{
		if ($eventId == null) {
			$eventId = JFactory::getApplication()->input->get('e_id');
		}
		if (!isset($this->events[$eventId]) || $force) {
			JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dpcalendar/models', 'DPCalendarModel');
			$model = JModelLegacy::getInstance('Event', 'DPCalendarModel');
			$event = JTable::getInstance('Event', 'DPCalendarTable');

			if ($e = $model->getItem($eventId)) {
				$event->bind($e);
				$event->tickets = $e->tickets;
			}

			if (empty($event->tickets)) {
				$event->tickets = [];
			}

			$this->events[$eventId] = $event;
		}

		return $this->events[$eventId];
	}

	public function getTickets($bookingId)
	{
		$ticketsModel = JModelLegacy::getInstance('Tickets', 'DPCalendarModel', array('ignore_request' => true));
		$ticketsModel->setState('filter.booking_id', $bookingId);
		$ticketsModel->setState('list.limit', 10000);

		return $ticketsModel->getItems();
	}
}
