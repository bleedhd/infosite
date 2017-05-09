<?php

return function ($site, $pages, $page) {

	$url = $site->defaultLandingpage()->toUrl();

	if ($url) {
		go($url . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']));
	}

};
