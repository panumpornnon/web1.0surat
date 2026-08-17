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
	public function init()
	{
		$this->booking = $this->get('Item');
		$this->form    = $this->get('Form');
		$this->tickets = [];

		if (!empty($this->booking) && isset($this->booking->id)) {
			$this->form->bind($this->booking);
			$this->tickets = $this->getModel()->getTickets($this->booking->id);

			$this->form->removeField('event_id');
			$this->form->removeField('amount');
		} else {
			$this->form->setFieldAttribute('event_id', 'required', 'true');
		}
		$this->form->removeField('options');

		$this->form->setFieldAttribute('user_id', 'onchange', 'DPCalendar.updateBookingMail()');
	}

	protected function addToolbar()
	{
		$this->input->set('hidemainmenu', true);

		$isNew = ($this->booking->id == 0);
		$canDo = DPCalendarHelper::getActions();

		if ($canDo->get('core.edit')) {
			JToolbarHelper::apply('booking.apply');
			JToolbarHelper::save('booking.save');
		}
		if ($canDo->get('core.create')) {
			JToolbarHelper::save2new('booking.save2new');
		}
		if (!$isNew && $canDo->get('core.create')) {
			JToolbarHelper::save2copy('booking.save2copy');
		}
		if (empty($this->booking->id)) {
			JToolbarHelper::cancel('booking.cancel');
		} else {
			JToolbarHelper::cancel('booking.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		parent::addToolbar();
	}
}
