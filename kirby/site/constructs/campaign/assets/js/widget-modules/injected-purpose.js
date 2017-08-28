/**
 * @name Injected Donation Purpose (campaign ID)
 */
Kirby.WidgetModules.register('injected-purpose', function ($, widget, options, config) {

	if (config.purpose) {
		options.extend({
			defaults: config.purpose,
		});
	}

});
