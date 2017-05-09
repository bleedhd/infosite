<?php

/**
 * This file is an approximation of the .htaccess routing for the bult-in PHP server. Due to the way that the
 * built-in PHP server handles requests, certain Kirby routes - in particular plugin asset routes - don't work
 * in that context. This routing file for the PHP server emulates the behavior that Kirby expects by manipulating
 * the global server variables before handing control over to Kirby.
 *
 * Usage:
 * $ php -S localhost:8080 kirby-router.php
 */

// theoretical path of the file that is actually requested
$url = parse_url($_SERVER['REQUEST_URI']);
$file = __DIR__ . $url['path'];

if (file_exists($file)) {
	// if the file exists, just resume normal operation
	return false;
} else {
	// Kirby relies heavily on the SCRIPT_NAME and SCRIPT_FILENAME variables being set "properly".
	// The following rules mostly mirror the behavior of the .htaccess file
	if (preg_match('/^\/([^\/]+)/', $url['path'], $matches)) {
		if ($matches[1] === 'panel') {
			$_SERVER['SCRIPT_NAME'] = '/panel/index.php';
			$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/panel/index.php';
			include('panel/index.php');
		} else {
			$_SERVER['SCRIPT_NAME'] = '/index.php';
			$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
			include('index.php');
		}

		return true;
	}
}

return false;
