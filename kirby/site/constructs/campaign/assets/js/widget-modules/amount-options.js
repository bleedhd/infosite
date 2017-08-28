/**
 * @name Amount Options Override
 */
Kirby.WidgetModules.register('amount-options', function ($, widget, options, config) {

	function toRnwAmount(amount) {
		return {
			text: amount,
			value: 100 * amount,
		};
	}

	var intervalFactors = {
		weekly: 0.25,
		monthly: 1,
		quarterly: 3,
		semestral: 6,
		yearly: 12,
	};

	if (config.amounts && config.amounts.onetime) {
		options.translations.step_amount.onetime_amounts = $.map(config.amounts.onetime, toRnwAmount);
	}

	if (config.amounts && config.amounts.recurring) {
		options.translations.step_amount.recurring_amounts = $.map(config.amounts.recurring, toRnwAmount);
	}

	// Override widget configuration minimum amount(s)
	if (config.min_amount.single) {
		options.common.min_amount.single = parseInt(config.min_amount.single);
	}

	if (config.min_amount.recurring) {
		var scaled = {};
		$.each(intervalFactors, function (key, factor) {
			scaled[key] = factor * config.min_amount.recurring;
		});

		options.common.min_amount.recurring = scaled;
	}

});
