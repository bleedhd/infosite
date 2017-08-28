(function (Kirby, config) {
	window.rnwWidget = window.rnwWidget || {};
	window.rnwWidget.configureWidget = function(options) {
		var widget = options.widget,
			$ = widget.j,
			urlParams = window.rnwWidget.utils.getUrlParam();

		window.donationwidget = widget;

		options.epikOptions.test_mode = config.testMode;
		if (config.stylesheet) {
			if (config.stylesheet.startsWith('rnw://')) {
				options.css = [options.widgetPreferredUrl + config.stylesheet.substring(6)];
			} else {
				options.css = [config.stylesheet];
			}
		}

		options.extend({
			defaults: {
				amount: urlParams.amount,
				recurring_interval: urlParams.interval ? widget.intervalNameToExpression(urlParams.interval) : null,
			},
		});

		Kirby.WidgetModules.run($, widget, options, config);

		<?php echo $widget->userCode(); ?>
	};
})(Kirby, <?php echo a::json($widget->jsConfig()); ?>);
