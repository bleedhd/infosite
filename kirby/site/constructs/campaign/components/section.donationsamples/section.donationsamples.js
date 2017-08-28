var DonationSamples = (function($) {

	// when applied to the onkeypress event, this prevents all non-numeric keys from being used.
	function blockNonNumeric(e) {
		if (e.charCode != 0 && (e.charCode < 48 || e.charCode > 57)) {
			e.preventDefault();
		}
	}

	function init() {
		$('.donation-custom').each(function () {
			var customAmount = $(this).find('.donation-amount'),
				checkoutLink = $(this).find('.donation-checkout');

			customAmount.on('keypress', blockNonNumeric);
			checkoutLink.on('click', function (e) {
				e.preventDefault();

				// if
				// * the amount field is empty
				// * the amount field contains anything that cannot be converted to an int properly,
				// * the amount is below the minimum value
				// the default link handling kicks in and should bring the user to the checkout page anyway.
				var amount = parseInt(customAmount.val()),
					min = parseInt(customAmount.attr('min')) || 1,
					max = parseInt(customAmount.attr('max'));

				if (amount >= min && (amount <= max || !max)) {
					var url = $(this).attr('href');

					url += (url.indexOf('?') < 0 ? '?' : '&');
					url += 'amount=' + (100 * amount);
					window.location.href = url;
				}
			});
		});
	}

	// EventEmitter listen for apps init
	ee.addListener('document-ready', init);

	// Public API
	return {
		init: init
	};

})(jQuery);
