<?php

kirby()->plugin('getutils');

$widgetController = new \Getunik\Campaign\WidgetController();
$redirectController = new \Getunik\Campaign\RedirectController();

kirby()->routes([
	'widget-payment-success' => [
		'method' => 'POST',
		'pattern' => 'widgets/payment-success',
		'action'  => [$widgetController, 'paymentSuccessAction'],
	],
	'widget-callback' => [
		'method' => 'GET',
		'pattern' => 'widgets/(:all)',
		'action'  => [$widgetController, 'widgetCallbackAction'],
	],
	'style-guide-permalink' => [
		'pattern' => 'styles',
		'action'  => function() {
			return go(c::get('styleguide-path', 'style-guide'));
		}
	],
	'user-redirects' => [
		'pattern' => c::get('user-redirects.pattern', 'r/(:all)'),
		'action' => [$redirectController, 'redirectAction'],
	],
]);

\GetUtils\Assets\KirbyJs::instance()->registerUtil('widget-modules-registry', implode(DS, [$construct->assetsPath(), 'widget-scripts', 'widget-modules-registry.js']));
