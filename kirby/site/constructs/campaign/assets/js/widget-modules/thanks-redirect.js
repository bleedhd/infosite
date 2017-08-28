/**
 * @name Thanks Page Redirect
 *
 * Redirects to a dedicated thanks page.
 */
Kirby.WidgetModules.register('thanks-redirect', function ($, widget, options, config) {

	if (config.thanksPageUrl) {
		options.widget.on(rnwWidget.constants.events.PAYMENT_COMPLETE, function (e) {

			if (e.paymentStatus === 'success') {
				e.preventDefault();

				$.post(Kirby.url('widgets/payment-success'), e.payment).always(function () {
					window.location.href = config.thanksPageUrl;
				});
			}
		});
	}

});
