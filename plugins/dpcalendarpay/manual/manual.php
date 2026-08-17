<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

use Omnipay\Omnipay;

if (!JLoader::import('components.com_dpcalendar.helpers.dpcalendar', JPATH_ADMINISTRATOR)) {
	return;
}

class PlgDPCalendarPayManual extends \DPCalendar\Plugin\PaymentPlugin
{

	/**
	 *
	 * @return \Omnipay\Manual\Gateway
	 */
	protected function getPaymentGateway()
	{
		$gateway = Omnipay::create('Manual');

		return $gateway;
	}

	protected function getPaymentData($gateway, $transactionData, $booking)
	{
		$updates = array(
			'state'          => 4,
			'payer_email'    => $booking->email,
			'transaction_id' => md5($booking->id . 'dpcalendar')
		);

		return $updates;
	}
}
