/**
 * @name Select Newsletter Checkbox
 *
 * Checks the newsletter checkbox by default.
 */
Kirby.WidgetModules.register('select-newsletter', function ($, widget, options, config) {

	options.extend({
		defaults: {
			stored_customer_email_permission: true,
		},
	});

});
