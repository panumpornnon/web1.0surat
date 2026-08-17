<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

JLoader::import('joomla.application.component.controllerform');

class DPCalendarControllerBooking extends JControllerForm
{

	protected $text_prefix = 'COM_DPCALENDAR_BOOKING';

	public function mail()
	{
		$data = (array)JFactory::getUser($this->input->getInt('id'));
		unset($data['password']);
		DPCalendarHelper::sendMessage(null, false, $data);
	}

	public function invoice()
	{
		$model   = $this->getModel('Booking', 'DPCalendarModel', array('ignore_request' => false));
		$state   = $model->getState();
		$booking = $model->getItem();

		if ($booking == null) {
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$fileName = \DPCalendar\Helper\Booking::createInvoice($booking, $model->getTickets($booking->id), $state->params);
		if ($fileName) {
			JFactory::getApplication()->close();
		} else {
			JFactory::getApplication()->redirect(DPCalendarHelperRoute::getBookingRoute($booking));
		}
	}

	public function invoicesend()
	{
		$model   = $this->getModel('Booking', 'DPCalendarModel', array('ignore_request' => false));
		$state   = $model->getState();
		$booking = $model->getItem();

		if ($booking == null) {
			throw new Exception('JERROR_ALERTNOAUTHOR', 403);
		}

		JFactory::getLanguage()->load('com_dpcalendar', JPATH_ADMINISTRATOR . '/components/com_dpcalendar');

		$tickets = $model->getTickets($booking->id);

		$params = clone JComponentHelper::getParams('com_dpcalendar');
		$params->set('show_header', false);

		$details = DPCalendarHelper::renderLayout(
			'booking.invoice',
			array(
				'booking'    => $booking,
				'tickets'    => $tickets,
				'translator' => new \DPCalendar\Translator\Translator(),
				'dateHelper' => new \DPCalendar\Helper\DateHelper(),
				'params'     => $params,
			)
		);

		$additionalVars = array(
			'bookingDetails' => $details,
			'bookingLink'    => DPCalendarHelperRoute::getBookingRoute($booking, true),
			'bookingUid'     => $booking->uid,
			'sitename'       => JFactory::getConfig()->get('sitename'),
			'user'           => JFactory::getUser()->name
		);

		$subject = DPCalendarHelper::renderEvents(array($booking), JText::_('COM_DPCALENDAR_BOOK_NOTIFICATION_SEND_SUBJECT'), null, $additionalVars);
		$body    = DPCalendarHelper::renderEvents(array($booking), JText::_('COM_DPCALENDAR_BOOK_NOTIFICATION_SEND_BODY'), null, $additionalVars);

		// Send to the ticket holder
		$mailer = JFactory::getMailer();
		$mailer->setSubject($subject);
		$mailer->setBody($body);
		$mailer->IsHTML(true);
		$mailer->addRecipient($booking->email);

		// Attache the new ticket
		$params->set('show_header', true);
		$fileName = \DPCalendar\Helper\Booking::createInvoice($booking, $tickets, $state->params, true);
		if ($fileName) {
			$mailer->addAttachment($fileName);
		}
		$mailer->Send();
		if ($fileName) {
			JFile::delete($fileName);
		}

		JFactory::getApplication()->enqueueMessage(JText::_('COM_DPCALENDAR_CONTROLLER_SEND_SUCCESS'));

		JFactory::getApplication()->redirect(base64_decode($this->input->getBase64('return')));
	}

	public function save($key = null, $urlVar = 'b_id')
	{
		$data = $this->input->post->get('jform', array(), 'array');

		if (empty($data['id'])) {
			$event = $this->getModel()->getEvent($data['event_id']);
			if (!$event) {
				return false;
			}

			$amount = array();
			if ($event->price) {
				foreach ($event->price->value as $index => $value) {
					$amount[$index] = key_exists('amount', $data) ? $data['amount'] : 1;
				}
			} else {
				$amount[0] = 1;
			}

			$data['event_id'] = array($event->id => ['tickets' => $amount]);
			$this->input->post->set('jform', $data);
		}

		return parent::save($key, $urlVar);
	}

	public function edit($key = null, $urlVar = 'b_id')
	{
		return parent::edit($key, $urlVar);
	}

	public function cancel($key = 'b_id')
	{
		return parent::cancel($key);
	}
}
