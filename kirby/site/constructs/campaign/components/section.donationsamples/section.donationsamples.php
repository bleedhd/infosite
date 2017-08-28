<?php

use Getunik\Campaign\WidgetConfig;


return function ($site, $pages, $page) {
	$widget = WidgetConfig::getWidgetConfigPage($page->widget()->value());

	$donationUrl = function ($amount = NULL, $interval = NULL) use ($page) {
		$url = $page->widgetPage()->toUrl();
		// double escape because "normal" escaped slashes break with an Apache server in its default configuration
		$url .= '/s:' . str_replace('%', '%25', esc($page->uri(), 'url'));

		$query = [];

		if ($amount) {
			$query['amount'] = 100 * $amount;
		}

		if ($interval && $interval !== 'none') {
			$query['interval'] = $interval;
		}

		if (!empty($query)) {
			$url = $url . '?' . url::queryToString($query);
		}

		return $url;
	};

	$getLimit = function ($box, $limitType) use ($widget) {
		if ($limitType === 'min') {
			return ($box->intervalType()->value() === 'none' ? $widget->onetimeMinAmount() : $widget->recurringMinAmount());
		} else {
			return ($box->intervalType()->value() === 'none' ? $widget->onetimeMaxAmount() : $widget->recurringMaxAmount());
		}
	};

	return compact('donationUrl', 'getLimit');
};
