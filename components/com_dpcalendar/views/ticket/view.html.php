<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

JLoader::import('components.com_dpcalendar.libraries.phpqrcode.phpqrcode', JPATH_ADMINISTRATOR);

class DPCalendarViewTicket extends \DPCalendar\View\BaseView
{

	public function display($tpl = null)
	{
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_dpcalendar/models');
		$model = JModelLegacy::getInstance('Ticket', 'DPCalendarModel');
		$this->setModel($model, true);

		parent::display($tpl);
	}

	protected function init()
	{
		$ticket = $this->getModel()->getItem(array('uid' => $this->input->getCmd('uid')));

		if ($ticket->id == null) {
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
		}

		$this->event   = JModelLegacy::getInstance('Event', 'DPCalendarModel')->getItem($ticket->event_id);
		$this->booking = JModelLegacy::getInstance('Booking', 'DPCalendarModel')->getItem($ticket->booking_id);

		if (!$this->booking || $this->booking->id == null) {
			throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
		}

		// Try to find the label of the ticket type
		$ticket->price_label       = '';
		$ticket->price_description = '';
		if ($this->event->price
			&& $ticket->price
			&& key_exists($ticket->type, $this->event->price->label)
			&& $this->event->price->label[$ticket->type]) {
			$ticket->price_label = $this->event->price->label[$ticket->type];

			if ($this->event->price->description[$ticket->type]) {
				$ticket->price_description = $this->event->price->description[$ticket->type];
			}
		}

		$ticket->text = '';
		$this->app->triggerEvent('onContentPrepare', ['com_dpcalendar.ticket', &$ticket, &$this->params, 0]);

		$ticket->displayEvent                       = new stdClass();
		$results                                    = $this->app->triggerEvent(
			'onContentBeforeDisplay',
			['com_dpcalendar.ticket', &$ticket, &$this->params, 0]
		);
		$ticket->displayEvent->beforeDisplayContent = trim(implode("\n", $results));

		$results                                   = $this->app->triggerEvent(
			'onContentAfterDisplay',
			['com_dpcalendar.ticket', &$ticket, &$this->params, 0]
		);
		$ticket->displayEvent->afterDisplayContent = trim(implode("\n", $results));

		$this->ticketFields   = [];
		$this->ticketFields[] = (object)array('id' => 'name', 'name' => 'name', 'label' => 'COM_DPCALENDAR_TICKET_FIELD_NAME_LABEL');
		$this->ticketFields[] = (object)array('id' => 'email', 'name' => 'email');

		if ($this->params->get('ticket_show_seat', 1)) {
			$this->ticketFields[] = (object)array('id' => 'seat', 'name' => 'seat', 'label' => 'COM_DPCALENDAR_TICKET_FIELD_SEAT_LABEL');
		}

		$this->ticketFields[] = (object)array('id' => 'country', 'name' => 'country', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_COUNTRY_LABEL');
		$this->ticketFields[] = (object)array(
			'id'    => 'province',
			'name'  => 'province',
			'label' => 'COM_DPCALENDAR_LOCATION_FIELD_PROVINCE_LABEL'
		);
		$this->ticketFields[] = (object)array('id' => 'city', 'name' => 'city', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_CITY_LABEL');
		$this->ticketFields[] = (object)array('id' => 'zip', 'name' => 'zip', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_ZIP_LABEL');
		$this->ticketFields[] = (object)array('id' => 'street', 'name' => 'street', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_STREET_LABEL');
		$this->ticketFields[] = (object)array('id' => 'number', 'name' => 'number', 'label' => 'COM_DPCALENDAR_LOCATION_FIELD_NUMBER_LABEL');
		$this->ticketFields[] = (object)array('id' => 'telephone', 'name' => 'telephone');

		$this->ticketFields = array_merge($this->ticketFields, $ticket->jcfields);

		\DPCalendar\Helper\DPCalendarHelper::sortFields($this->ticketFields, $this->params->get('ticket_fields_order', new stdClass()));

		foreach ($this->ticketFields as $key => $field) {
			if (!$this->params->get('ticket_show_' . $field->name, 1)) {
				unset($this->ticketFields[$key]);
				continue;
			}

			$label = 'COM_DPCALENDAR_BOOKING_FIELD_' . strtoupper($field->name) . '_LABEL';

			if (isset($field->label)) {
				$label = $field->label;
			}

			$content = '';
			if (property_exists($ticket, $field->name)) {
				$content = $ticket->{$field->name};
			}
			if (property_exists($field, 'value')) {
				$content = $field->value;
			}

			if (!$content) {
				unset($this->ticketFields[$key]);
				continue;
			}

			$field->dpDisplayLabel   = $label;
			$field->dpDisplayContent = $content;
		}

		$this->qrCodeString = '';
		if ($this->params->get('ticket_show_barcode', 1)) {
			// Creating a QR code is memory intensive
			DPCalendarHelper::increaseMemoryLimit(130 * 1024 * 1024);

			// The image needs to be collected from the output
			ob_start();
			$barcodeobj = new TCPDF2DBarcode(DPCalendarHelperRoute::getTicketCheckinRoute($ticket, true), 'QRCODE,L');
			$barcodeobj->getBarcodePNG(150, 150);
			$this->qrCodeString = base64_encode(ob_get_contents());
			ob_end_clean();
		}

		$this->ticket = $ticket;
	}
}
