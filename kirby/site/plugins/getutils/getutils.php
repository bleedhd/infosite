<?php

require(__DIR__ . DS . 'vendor' . DS . 'autoload.php');

use Detection\MobileDetect;
use GetUtils\DataLayer;
use GetUtils\XmlSitemapController;


foreach (glob(implode(DS, [__DIR__, 'snippets', '*.php'])) as $snippet) {
	$kirby->set('snippet', basename($snippet, '.php'), $snippet);
}

foreach (glob(implode(DS, [__DIR__, 'fields', '*.yml'])) as $field) {
	$kirby->set('blueprint', 'fields/' . basename($field, '.yml'), $field);
}

function responsive($file, $imageStyle = NULL, $data = [])
{
	if ($file) {
		$defaults = [
			'class' => [\GetUtils\ImageStyles::getDefaultClass(), $imageStyle],
			'src' => '',
		];

		return snippet('responsive-image', [
			'attributes' => \GetUtils\ImageStyles::getDataAttributes($file, $imageStyle)->merge($defaults),
			'imageStyle' => $imageStyle,
			'data' => $data,
		], true);
	}
}

\GetUtils\ImageStyles::registerJsUtils(\GetUtils\Assets\KirbyJs::instance());

/**
 * Registering routes
 */
$kirby->routes([
	'XmlSitemap' => [
		'pattern' => 'sitemap.xml',
		'method' => 'GET',
		'action'  => [XmlSitemapController::class, 'buildSitemap'],
	],
]);

/**
 * Helper function to work around the issue of plugin asset routes (/assets/plugin/_plugin-name_/...) not working
 * with the built-in PHP server.
 */
function pluginAssetPath($plugin)
{
	return str_replace('{plugin}', $plugin, c::get('plugin-assets-path', '/assets/plugins/{plugin}'));
}

function assets($assetType)
{
	return GetUtils\Assets\AssetManager::instance()->getRegistry($assetType);
}

/**
 * Helper function that adds the Kirby JavaScript object with constants and utilities.
 *
 * @param $page
 *   The page for which the Kirby helper should be generated.
 *
 * @return string
 */
function kirbyjs($page)
{
	$kirbyjs = \GetUtils\Assets\KirbyJs::instance();
	$kirbyjs
		->registerConstants([
			'baseUrl' => $page->site()->url(),
			'langUrl' => $page->site()->language()->url(),
		])
		->registerUtil('kirby-url-utils', __DIR__ . DS . 'assets' . DS . 'kirby-url-utils.js');

	return implode(PHP_EOL, [
		'<script type="text/javascript">',
		$kirbyjs->render(),
		'</script>',
	]);
}

/**
 * Helper function for the data layer. Add the following piece of code to your HTML head to integrate the server-side
 * DataLayer API with the client-side.
 *
 * {@code <?php echo dataLayer(); ?> }
 *
 * @return string
 */
function dataLayer()
{
	return implode(PHP_EOL, [
		'<script type="text/javascript">',
		DataLayer::flush(),
		'</script>',
	]);
}

/**
 * This helper builds a HTML class string from a mixed array. An associative element (one with a non-numeric index)
 * will be added to the class list as-is while elements with a string as their index will use that index as a class
 * if the associated value is "truthy".
 *
 * {@code <?php echo classes([
 *   'test',
 *   'conditional' => c::get('debug'),
 * ]); ?> }
 *
 * @param array $classMap
 *   The mixed PHP array to convert to a class string.
 *
 * @return string
 *   A string of CSS classes separated with spaces.
 */
function classes($classMap)
{
	$classes = [];
	foreach ($classMap as $key => $value) {
		if (is_int($key)) {
			$classes[] = $value;
		} else if ($value) {
			$classes[] = $key;
		}
	}

	return implode(' ', $classes);
}

/**
 * Helper function that returns a MobileDetect device instance created from the current request information.
 *
 * @return MobileDetect
 */
function device()
{
	return new MobileDetect();
}

/**
 * Returns an array of browser capability properties.
 *
 * @return array
 *   An array of browser capability properties, ideal for processing with the {@code classes()} helper function.
 */
function browserCaps()
{
	$caps = new \GetUtils\BrowserCapabilities();
	return $caps->getAllCapabilities('cap-');
}

require_once(__DIR__ . '/field.methods.php');
