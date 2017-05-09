<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'K2-PRO-62a8da9d2660ddcd003c45af41a9ad7d');

// http://php.net/manual/en/function.strftime.php
c::set('date.handler', 'strftime');

/*

---------------------------------------
Languages
---------------------------------------

Kirby has built-in support for multi-language sites.
http://getkirby.com/docs/languages/setup

*/

c::set('languages', [
	[
		'code' => 'de',
		'name' => 'Deutsch',
		'default' => true,
		'locale' => 'de_CH.UTF-8',
		'url' => '/de',
	],
	[
		'code' => 'fr',
		'name' => 'Français',
		'default' => false,
		'locale' => 'fr_CH.UTF-8',
		'url' => '/fr',
	],
	[
		'code' => 'it',
		'name' => 'Italiano',
		'default' => false,
		'locale' => 'it_CH.UTF-8',
		'url' => '/it',
	],
	[
		'code' => 'en',
		'name' => 'English',
		'default' => false,
		'locale' => 'en_US.UTF-8',
		'url' => '/en',
	],
]);

c::set('facebookLanguage', [
	'de' => 'de_DE',
	'fr' => 'fr_FR',
	'it' => 'it_IT',
	'en' => 'en_EN',
]);

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

c::set('debug', false);

/*

---------------------------------------
Subfolder Setup
---------------------------------------

Kirby will automatically try to detect the subfolder

i.e. http://yourdomain.com/subfolder

This might fail depending on your server setup.
In such a case, please set the correct subfolder here.

You must also set the right url then:

c::set('url', 'http://yoururl.com/subfolder');

if you are using the .htaccess file, make sure to
set the right RewriteBase there as well:

RewriteBase /subfolder

*/

c::set('subfolder', false);

/*

---------------------------------------
Homepage Setup
---------------------------------------

By default the folder/uri for your homepage is "home".
Sometimes it makes sense to change that to make your blog
your homepage for example. Just change it here in that case.

*/

c::set('home', 'home');

/*

---------------------------------------
Markdown Setup
---------------------------------------

You can globally switch Markdown parsing
on or off here.

To disable automatic line breaks in markdown
set markdown.breaks to false.

You can also switch between regular markdown
or markdown extra: http://michelf.com/projects/php-markdown/extra/

*/

c::set('markdown', true);
c::set('markdown.breaks', true);
c::set('markdown.extra', true);

/*

---------------------------------------
User Roles Setup
---------------------------------------

*/
c::set('roles', [
	[
		'id' => 'admin',
		'name' => 'Admin',
		'panel' => true,
	],
	[
		'id' => 'editor',
		'name' => 'Editor',
		'default' => true,
		'panel' => true,
	],
]);


/*

---------------------------------------
Responsive Image Styles
---------------------------------------

*/

c::set('image-style.breakpoints', ['xl', 'lg', 'md', 'sm', 'xs']);
c::set('image-style.default-class', 'img-fluid');

c::set('image-style.definitions', [
	'banner' => [
		// setting a breakpoint explicitly to NULL ensures that the original image URL is used
		'lg' => [
			'width' => 1440,
			'height' => 796,
			'crop' => true,
			'quality' => 100,
		],
		'md' => [
			'width' => 720,
			'height' => 300,
			'crop' => true,
			'quality' => 100,
		],
		'sm' => [
			'width' => 320,
			'height' => 200,
			'crop' => true,
			'quality' => 100,
		],
	],
	'slick-slider-image' => [
		// setting a breakpoint explicitly to NULL ensures that the original image URL is used
		'xl' => [
			'width' => 1440,
			'height' => 796,
			'crop' => true,
			'quality' => 100,
		],
		'xs' => [
			'width' => 720,
			'height' => 480,
			'crop' => true,
			'quality' => 100,
		],
	],
	'donate-sample-image' => [
		// setting a breakpoint explicitly to NULL ensures that the original image URL is used
		'xl' => [
			'width' => 615,
			'height' => 342,
			'crop' => true,
			'quality' => 100,
		],
	],
]);

/*


-----------------------------
RaiseNow Widget Configuration
-----------------------------

*/

// Setting testMode to false will force production mode
//c::set('widget.testMode', false);


/*

------------------------------
Project Specific Configuration
------------------------------

*/

c::set('xml-sitemap-indexable', true);

/*
---------------------
Contact Form Settings
---------------------
*/

c::set('contact-form-recipient', 'lsr@getunik.com');
c::set('contact-thanks-page', '/contact-thanks');


/*
-------------------
RNW/Widget Settings
-------------------
*/

c::set('widget.defaultModules', ['amount-options', 'injected-purpose', 'thanks-redirect']);


/*
--------------------
Environment Settings
--------------------
*/

if (file_exists(__DIR__ . '/config-loader.php')) {
	include(__DIR__ . '/config-loader.php');
}
