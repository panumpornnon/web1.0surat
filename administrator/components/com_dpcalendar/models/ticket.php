<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

JLoader::import('joomla.application.component.modeladmin');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/tables');

class DPCalendarModelTicket extends JModelAdmin
{
	/**
	 * Flag when multiple tickets are saved but only one captcha can be rendered.
	 *
	 * @var bool
	 */
	public $ignoreCaptcha = false;

	public function save($data)
	{
		$oldItem = $this->getItem($data['id'] ? $data['id'] : -1);

		// Fetch the latitude/longitude if location has changed
		$location    = \DPCalendar\Helper\Location::format(array(ArrayHelper::toObject($data)));
		$oldLocation = \DPCalendar\Helper\Location::format(array($oldItem));
		if ($oldLocation != $location || (!isset($data['longitude']) || !$data['longitude'])) {
			$data['latitude']  = 0;
			$data['longitude'] = 0;
			if ($location) {
				$location = \DPCalendar\Helper\Location::get($location, false);
				if ($location->latitude) {
					$data['latitude']  = $location->latitude;
					$data['longitude'] = $location->longitude;
				}
			}
		}

		if (!isset($data['remind_time']) || !$data['remind_time']) {
			$form                = $this->getForm();
			$data['remind_time'] = $form->getFieldAttribute('remind_time', 'default');
			$data['remind_type'] = $form->getFieldAttribute('remind_type', 'default');
		}

		$success = parent::save($data);

		// Only a notification about the ticket update is sent, new items are
		// notified in the booking model.
		if ($success && $oldItem && $oldItem->id) {
			JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dpcalendar/models', 'DPCalendarModel');

			$ticket = $this->getItem($this->getState($this->getName() . '.id'));
			$event  = JModelLegacy::getInstance('Event', 'DPCalendarModel')->getItem($ticket->event_id);

			// Create the ticket details for mail notification
			$params = clone JComponentHelper::getParams('com_dpcalendar');
			$params->set('show_header', false);

			$details = DPCalendarHelper::renderLayout(
				'ticket.details',
				array(
					'ticket'     => $ticket,
					'event'      => $event,
					'translator' => new \DPCalendar\Translator\Translator(),
					'dateHelper' => new \DPCalendar\Helper\DateHelper(),
					'params'     => $params
				)
			);

			$additionalVars = array(
				'ticketDetails' => $details,
				'ticketLink'    => DPCalendarHelperRoute::getTicketRoute($ticket, true),
				'ticketUid'     => $ticket->uid,
				'sitename'      => JFactory::getConfig()->get('sitename'),
				'user'          => JFactory::getUser()->name
			);

			JFactory::getLanguage()->load('com_dpcalendar', JPATH_ADMINISTRATOR . '/components/com_dpcalendar');

			$subject = DPCalendarHelper::renderEvents(array($event), JText::_('COM_DPCALENDAR_NOTIFICATION_EVENT_SUBJECT_EDIT'));
			$body    = DPCalendarHelper::renderEvents(array($event), JText::_('COM_DPCALENDAR_NOTIFICATION_EVENT_TICKET_BODY'), null,
				$additionalVars);

			// Send to the author
			$mailer = JFactory::getMailer();
			$mailer->setSubject($subject);
			$mailer->setBody($body);
			$mailer->IsHTML(true);
			$mailer->addRecipient(JFactory::getUser($event->created_by)->email);
			$mailer->Send();

			// Send to the ticket holder
			$mailer = JFactory::getMailer();
			$mailer->setSubject($subject);
			$mailer->setBody($body);
			$mailer->IsHTML(true);
			$mailer->addRecipient($ticket->email);

			// Attache the new ticket
			$params->set('show_header', true);
			$fileName = \DPCalendar\Helper\Booking::createTicket($ticket, $params, true);
			if ($fileName) {
				$mailer->addAttachment($fileName);
			}
			$mailer->Send();
			if ($fileName) {
				JFile::delete($fileName);
			}
		}

		return $success;
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

	public function delete(&$pks)
	{
		$pks = (array)$pks;

		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/tables', 'DPCalendarTable');
		$events = array();
		foreach ($pks as $i => $pk) {
			$event = JTable::getInstance('Event', 'DPCalendarTable');
			$event->load($this->getItem($pk)->event_id);
			$events[] = $event;
		}

		$success = parent::delete($pks);

		if ($success) {
			foreach ($events as $event) {
				$event->book(false, $event->id);
			}
		}

		return $success;
	}

	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);

		if ($item) {
			$user         = JFactory::getUser();
			$item->params = new Registry();
			$item->params->set('access-edit', $user->id == $item->user_id || $user->authorise('core.admin', 'com_dpcalendar'));

			$bookingFromSession = JFactory::getSession()->get('booking_id', 0, 'com_dpcalendar');
			if ($user->guest && $bookingFromSession != $item->booking_id) {
				$item->params->set('access-edit', false);
			}
		}

		return $item;
	}

	public function getTable($type = 'Ticket', $prefix = 'DPCalendarTable', $config = array())
	{
		$table = JTable::getInstance($type, $prefix, $config);
		$table->check();

		return $table;
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

	public function getForm($data = array(), $loadData = true)
	{
		JForm::addFormPath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/models/forms');

		$form = $this->loadForm('com_dpcalendar.ticket', 'ticket', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		$item = $this->getItem($this->getState($this->getName() . '.id', JFactory::getApplication()->input->getInt('t_id')));

		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dpcalendar/models', 'DPCalendarModel');
		$model = JModelLegacy::getInstance('Event', 'DPCalendarModel');
		$event = $item->event_id ? $model->getItem($item->event_id) : null;
		$user  = JFactory::getUser();

		if (!$event || !$user->authorise('core.edit.state', 'com_dpcalendar.category.' . $event->catid) || $user->id != $event->created_by) {
			// Disable fields for display.
			$form->setFieldAttribute('state', 'disabled', 'true');
			$form->setFieldAttribute('seat', 'disabled', 'true');
		}

		if (!$event || !$user->authorise('core.admin', 'com_dpcalendar')) {
			$form->setFieldAttribute('price', 'disabled', 'true');
		}
		$form->setFieldAttribute('event_id', 'disabled', 'true');
		$form->setFieldAttribute('booking_id', 'disabled', 'true');

		if (!DPCalendarHelper::isCaptchaNeeded() || $this->getState('captcha.disabled')) {
			$form->removeField('captcha');
		}

		if (JFactory::getApplication()->isClient('site')) {
			$form->removeField('user_id');
			$form->removeField('latitude');
			$form->removeField('longitude');
			$form->removeField('type');

			if (!$form->getValue('price') || $form->getValue('price') == '0.00') {
				$form->removeField('price');
			}
		}

		$this->modifyField($form, 'country');
		$this->modifyField($form, 'province');
		$this->modifyField($form, 'city');
		$this->modifyField($form, 'zip');
		$this->modifyField($form, 'street');
		$this->modifyField($form, 'number');
		$this->modifyField($form, 'telephone');
		$this->modifyField($form, 'public');
		$this->modifyField($form, 'remind_time');
		$this->modifyField($form, 'remind_type');

		return $form;
	}

	protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false)
	{
		// Handle the optional arguments.
		$options['control'] = ArrayHelper::getValue((array)$options, 'control', false);

		// Create a signature hash. But make sure, that loading the data does not create a new instance
		$sigoptions = $options;

		if (isset($sigoptions['load_data'])) {
			unset($sigoptions['load_data']);
		}

		$hash = md5($source . serialize($sigoptions));

		// Check if we can use a previously loaded form.
		if (!$clear && isset($this->_forms[$hash])) {
			return $this->_forms[$hash];
		}

		// Get the form.
		\JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
		\JForm::addFieldPath(JPATH_COMPONENT . '/models/fields');
		\JForm::addFormPath(JPATH_COMPONENT . '/model/form');
		\JForm::addFieldPath(JPATH_COMPONENT . '/model/field');

		try {
			$source = trim($source);

			if (empty($source)) {
				throw new \InvalidArgumentException(sprintf('%1$s(%2$s, *%3$s*)', __METHOD__, $name, gettype($source)));
			}

			// Instantiate the form.
			$form = new JForm($name, $options);

			// Load the data.
			if (substr($source, 0, 1) == '<') {
				if ($form->load($source, false, $xpath) == false) {
					throw new \RuntimeException(sprintf('%s() could not load form', __METHOD__));
				}
			} else {
				if ($form->loadFile($source, false, $xpath) == false) {
					throw new \RuntimeException(sprintf('%s() could not load file', __METHOD__));
				}
			}

			if (isset($options['load_data']) && $options['load_data']) {
				// Get the data for the form.
				$data = $this->loadFormData();
			} else {
				$data = array();
			}

			// Allow for additional modification of the form, and events to be triggered.
			// We pass the data because plugins may require it.
			$this->preprocessForm($form, $data);

			// Load the data into the form after the plugins have operated.
			$form->bind($data);
		} catch (\Exception $e) {
			$this->setError($e->getMessage());

			return false;
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

		$state = $params->get('ticket_form_' . $name, 1);
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
		$data = JFactory::getApplication()->getUserState('com_dpcalendar.edit.ticket.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		$this->preprocessData('com_dpcalendar.ticket', $data);

		return $data;
	}

	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}

	protected function populateState()
	{
		$app = JFactory::getApplication();

		$pk = $app->input->getInt('t_id');
		$this->setState('ticket.id', $pk);
		$this->setState('form.id', $pk);

		$return = $app->input->getVar('return', null, 'default', 'base64');

		if (!JUri::isInternal(base64_decode($return))) {
			$return = null;
		}

		$this->setState('return_page', base64_decode($return));
		$this->setState('captcha.disabled', false);

		$params = JComponentHelper::getParams('com_dpcalendar');

		if ($app->isClient('site')) {
			$params = $app->getParams();
		}
		$this->setState('params', $params);
	}
}
