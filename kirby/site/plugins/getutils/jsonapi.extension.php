<?php

use GetUtils\SearchConfig;
use GetUtils\SearchController;
use Lar\JsonApi\JsonApiUtil;


if (SearchConfig::apiEnabled()) {
	jsonapi()->register([
		// api/search
		[
			'method' => 'GET',
			'pattern' => SearchConfig::apiPath(),
			'action' => function () {
				$results = SearchController::search(site());
				return JsonApiUtil::pageToJson($results)->selectFields(SearchConfig::apiFields());
			},
		],
	]);
}
