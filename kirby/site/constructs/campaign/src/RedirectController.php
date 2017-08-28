<?php

namespace Getunik\Campaign;

use C;
use Page;
use Redirect;
use Response;


/**
 * Provides simple user-configurable redirect mechanism. "Pages" with a specific blueprint can be created to define
 * short URLs that are then redirected according to the values in those page objects.
 */
class RedirectController
{
	/**
	 * Action for the redirect route.
	 *
	 * @param string $name
	 *   The name (short URL) of the redirect to use
	 */
	public function redirectAction($name = 'default')
	{
		// Set up default language handling with 'lang' query string parameter
		$site = site();

		if (isset($_REQUEST['lang'])) {
			$lang = $site->language($_REQUEST['lang']);
			if ($lang) {
				$site->language = $lang;
			}
		}

		$root = page(C::get('user-redirects.root', 'system/redirects'));

		if ($root) {
			$config = $root->find(strtolower($name));

			if ($config) {
				$target = $this->getTargetUrl($config);

				if (isset($_REQUEST['debug']) && $_REQUEST['debug'] === 'true') {
					return Response::json(['target' => $target]);
				} else {
					Redirect::to($target);
				}
			}
		}

		Redirect::home();
	}

	/**
	 * Gets the target URL from the given redirect config page object.
	 *
	 * @param Page $config
	 *   The redirect config page.
	 *
	 * @return string
	 *   The target URL
	 */
	public function getTargetUrl(Page $config)
	{
		$base = $config->rewritePath()->toUrl();
		$query = $config->rewriteQuery()->value();

		return $base . ($query ? '?' . $query : '');
	}
}
