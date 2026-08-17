(function (document, Stripe) {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var root = document.querySelector('.plg-dpcalendarpay-stripe');
		Stripe.setPublishableKey(root.getAttribute('data-key'));

		document.querySelector('.plg-dpcalendarpay-stripe__button-bar .dp-button-submit').addEventListener('click', function () {
			var token = root.querySelector('[name="token"]').value;
			if (!!token) {
				this.form.submit();
			}

			this.setAttribute('disabled', true);

			Stripe.createToken(
				{
					name: root.querySelector('[name="card-holder"]').value,
					number: root.querySelector('[name="card-number"]').value,
					exp_month: parseInt(root.querySelector('[name="card-expiry-month"]').value),
					exp_year: parseInt(root.querySelector('[name="card-expiry-year"]').value),
					cvc: root.querySelector('[name="card-cvc"]').value
				},
				function (status, response) {
					[].slice.call(root.querySelectorAll('.dp-control')).forEach(function (group) {
						group.classList.remove('plg-dpcalendarpay-stripe__message_error');
					});

					if (!response.error) {
						root.querySelector('.plg-dpcalendarpay-stripe__message').display = 'none';
						root.querySelector('[name="token"]').value = response.id;
						root.querySelector('.plg-dpcalendarpay-stripe__form').submit();
						return;
					}

					var messageBox = root.querySelector('.plg-dpcalendarpay-stripe__message');
					if (response.error.code == 'incorrect_number') {
						root.querySelector('[name="card-number"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_INCORRECT_NUMBER');
					} else if (response.error.code == 'invalid_number') {
						root.querySelector('[name="card-number"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_NUMBER');
					} else if (response.error.code == 'invalid_expiry_month') {
						root.querySelector('[name="card-expiry-month"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_EXP_MONTH');
					} else if (response.error.code == 'invalid_expiry_year') {
						root.querySelector('[name="card-expiry-month"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_EXP_YEAR');
					} else if (response.error.code == 'invalid_cvc') {
						root.querySelector('[name="card-cvc"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_INVALID_CVC');
					} else if (response.error.code == 'expired_card') {
						root.querySelector('[name="card-expiry-month"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_EXPIRED_CARD');
					} else if (response.error.code == 'incorrect_cvc') {
						root.querySelector('[name="card-cvc"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_INCORRECT_CVC');
					} else if (response.error.code == 'card_declined') {
						root.querySelector('[name="card-number"]').closest('.dp-control').classList.add('plg-dpcalendarpay-stripe__message_error');
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_CARD_DECLINED');
					} else if (response.error.code == 'missing') {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_MISSING');
					} else if (response.error.code == 'processing_error') {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_PROCESSING_ERROR');
					} else if (status == 401) {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_UNAUTHORIZED');
					} else if (status == 402) {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_REQUEST_FAILED');
					} else if (status == 404) {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_NOT_FOUND');
					} else if (status >= 500) {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_SERVER_ERROR');
					} else {
						messageBox.textContent = Joomla.JText._('PLG_DPCALENDARPAY_STRIPE_FORM_UNKNOWN_ERROR');
					}

					messageBox.style.display = 'block';
					document.querySelector('.plg-dpcalendarpay-stripe__button-bar .dp-button-submit').disabled = false;
				}
			);

			return false;
		});
	});
})(document, Stripe);
