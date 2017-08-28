<?php

use Getunik\Campaign\WidgetConfig;
use GetUtils\Assets\AssetManager;
use GetUtils\Assets\BaseAssetRegistry;


return function ($site, $pages, $page) {
	$widget = NULL;

	if (param('s')) {
		// undo the double escape that is necessary for the slashes in page URIs
		$section = $pages->findByURI(rawurldecode(param('s')));
		if ($section) {
			$widget = new WidgetConfig($site, $page, $section->widget()->value());
			// Sets the default campaign purpose parameters - explicit campaign ID and sub-ID values on the
			// widget configuration take precedence.
			$widget->setFallbackPurpose([
				'stored_campaign_id' => $section->host()->uid(),
				'stored_campaign_subid' => $section->uid(),
				'stored_rnw_purpose_text' => $section->host()->title()->value(),
			]);
			// This will override the amounts of the widget configuration _if_ the section
			// has a 'onetimeAmounts' and/or 'recurringAmounts' field.
			$widget->addAmountOverrides($section);

			$jsAssets = AssetManager::instance()->getRegistry('js');
			$jsAssets->register([
				'type' => 'inline',
				'content' => Tpl::load(implode(DS, [__DIR__, '..', '..', 'assets', 'widget-scripts', 'widget-init.js.php']), compact('widget'), true),
			], BaseAssetRegistry::BUCKET_BOOTSTRAP);
			$jsAssets->register([
				'type' => 'script',
				'src' => $widget->url(),
			], BaseAssetRegistry::BUCKET_POST);
		}
	}

	return compact('widget');
};
