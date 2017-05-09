<?php

$injected = getenv('KIRBY_ENV');
define('ENVIRONMENT', $injected ? $injected : 'prod');

$types = ['config', 'secure', 'user'];
array_walk($types, function ($type) {
	$file = dirname(__FILE__) . '/' . $type . '.' . ENVIRONMENT . '.php';
	if (file_exists($file)) {
		include($file);
	}
});
