<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2018 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

$displayData['document']->loadLibrary(\DPCalendar\HTML\Document\HtmlDocument::LIBRARY_DPCORE);
$displayData['document']->loadScriptFile('form.js', 'plg_dpcalendarpay_stripe');
$displayData['document']->loadStyleFile('form.css', 'plg_dpcalendarpay_stripe');
$displayData['document']->loadScriptFile('https://js.stripe.com/v2/');

$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_INCORRECT_NUMBER');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_NUMBER');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_EXP_MONTH');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_EXP_YEAR');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_CVC');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_EXPIRED_CARD');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_INCORRECT_CVC');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_CARD_DECLINED');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_MISSING');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_PROCESSING_ERROR');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_UNAUTHORIZED');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_REQUEST_FAILED');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_NOT_FOUND');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_SERVER_ERROR');
$displayData['translator']->translateJS('PLG_DPCALENDARPAY_STRIPE_FORM_UNKNOWN_ERROR');
?>
<div class="plg-dpcalendarpay-stripe" data-key="<?php echo $displayData['params']->get('data-pkey'); ?>">
	<h3 class="dp-heading"><?php echo $displayData['translator']->translate('PLG_DPCALENDARPAY_STRIPE_FORM_HEADER') ?></h3>
	<div class="plg-dpcalendarpay-stripe__message dp-info-box dp-info-box_error"></div>
	<form action="<?php echo $displayData['returnUrl'] ?>" method="post" class="plg-dpcalendarpay-stripe__form dp-form">
		<div class="dp-control">
			<label for="card-holder" class="dp-control__label">
				<?php echo $displayData['translator']->translate('PLG_DPCALENDARPAY_STRIPE_FORM_CARDHOLDER') ?>
			</label>
			<div class="dp-control__input">
				<input type="text" name="card-holder" class="dp-form-input dp-form-input-text" value="<?php echo $displayData['booking']->name; ?>"/>
			</div>
		</div>
		<div class="dp-control">
			<label for="card-number" class="dp-control__label">
				<?php echo $displayData['translator']->translate('PLG_DPCALENDARPAY_STRIPE_FORM_CC') ?>
			</label>
			<div class="dp-control__input">
				<input type="text" name="card-number" class="dp-form-input dp-form-input-text"/>
			</div>
		</div>
		<div class="dp-control dp-control-expiry">
			<label for="card-expiry-month" class="dp-control__label">
				<?php echo $displayData['translator']->translate('PLG_DPCALENDARPAY_STRIPE_FORM_EXPDATE') ?>
			</label>
			<div class="dp-control__input">
				<select name="card-expiry-month" class="dp-select">
					<option>--</option>
					<?php for ($i = 1; $i <= 12; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo sprintf('%02u', $i); ?></option>
					<?php } ?>
				</select>
				<span> / </span>
				<select name="card-expiry-year" class="dp-select">
					<option>--</option>
					<?php $year = (int)gmdate('Y'); ?>
					<?php for ($i = 0; $i <= 10; $i++) { ?>
						<option value="<?php echo $i + $year; ?>"><?php echo sprintf('%04u', $i + $year); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="dp-control">
			<label for="card-cvc" class="dp-control__label">
				<?php echo $displayData['translator']->translate('PLG_DPCALENDARPAY_STRIPE_FORM_CVC') ?>
			</label>
			<div class="dp-control__input">
				<input type="text" name="card-cvc" class="dp-form-input dp-form-input-text dp-control__input-cvc"/>
			</div>
		</div>
		<div class="plg-dpcalendarpay-stripe__button-bar dp-button-bar">
			<button class="dp-button dp-button-action dp-button-cancel" type="button" data-href="<?php echo $displayData['cancelUrl']; ?>">
				<?php echo $displayData['layoutHelper']->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::CANCEL]); ?>
				<?php echo $displayData['translator']->translate('JCANCEL'); ?>
			</button>
			<button class="dp-button dp-button-submit" type="button">
				<?php echo $displayData['layoutHelper']->renderLayout('block.icon', ['icon' => \DPCalendar\HTML\Block\Icon::OK]); ?>
				<?php echo $displayData['translator']->translate('PLG_DPCALENDARPAY_STRIPE_FORM_PAYBUTTON'); ?>
			</button>
		</div>
		<input type="hidden" name="currency" value="<?php echo DPCalendarHelper::getComponentParameter('currency', 'USD'); ?>"
		       class="dp-form-input dp-form-input-hidden"/>
		<input type="hidden" name="amount" value="<?php echo $displayData['booking']->price ?>" class="dp-form-input dp-form-input-hidden"/>
		<input type="hidden" name="token" class="dp-form-input dp-form-input-hidden"/>
	</form>
</div>
