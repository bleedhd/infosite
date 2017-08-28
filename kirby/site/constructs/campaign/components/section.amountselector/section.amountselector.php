<?php

use Getunik\Campaign\WidgetConfig;


return function ($site, $pages, $page) {

	$onetime = $page->onetimeAmounts()->toStructure()->toArray();
	$recurring = $page->recurringAmounts()->toStructure()->toArray();
	$widget = WidgetConfig::getWidgetConfigPage($page->widget()->value());

	$amounts = [];
	for ($i = 0; $i < 3; $i++) {
		$amounts[] = new Obj([
			'onetime' => count($onetime) > $i ? $onetime[$i]->amount()->value() : 1,
			'recurring' => count($recurring) > $i ? $recurring[$i]->amount()->value() : 1,
		]);
	}

	$intervals = [];
	foreach ($page->intervals()->toStructure() as $intervalItem) {
		$intervals[] = new Obj([
			'value' => $intervalItem->intervalType()->value(),
			'label' => l::get('interval.' . $intervalItem->intervalType()->value()),
		]);
	}

	$box = new Obj([
		'minAmountOnetime' => $widget->onetimeMinAmount()->isEmpty() ? 1 : $widget->onetimeMinAmount()->value(),
		'maxAmountOnetime' => $widget->onetimeMaxAmount()->value(),
		'defaultAmountOnetime' => $page->onetimeDefaultAmount()->value(),
		'minAmountRecurring' => $widget->recurringMinAmount()->isEmpty() ? 1 : $widget->recurringMinAmount()->value(),
		'maxAmountRecurring' => $widget->recurringMaxAmount()->value(),
		'defaultAmountRecurring' => $page->recurringDefaultAmount()->value(),
		'defaultInterval' => $page->defaultInterval()->value(),
		'amounts' => $amounts,
		'intervals' => $intervals,
	]);

	$donationUrl = $page->widgetPage()->toUrl();
	// double escape because "normal" escaped slashes break with an Apache server in its default configuration
	$donationUrl .= '/s:' . str_replace('%', '%25', esc($page->uri(), 'url'));

	return compact('box', 'donationUrl');
};
