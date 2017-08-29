<?php

namespace GetUtils;

use Pages;
use Response;
use C;


/**
 * Controller for sitemap.xml route
 */
class XmlSitemapController
{
	/**
	 * sitemap.xml action. This action creates a simple XML sitemap for all pages on the site, allowing the site
	 * some control over which pages will be excluded from the sitemap.
	 *
	 * @return Response
	 *   The XML response for the route
	 */
	public static function buildSitemap()
	{
		$pages = kirby()->site()->index();
		$languages = iterator_to_array(kirby()->site()->languages());
		$filter = C::get('xml-sitemap-filter', [static::class, 'defaultFilter']);
		$pages = call_user_func($filter, $pages);
		$xml = snippet('xml-sitemap', ['pages' => $pages, 'languages' => $languages], true);

		return new Response($xml, 'text/xml');
	}

	/**
	 * Default sitemap filter function just excludes the global error page, pages listed in the 'xml-sitemap-exclude'
	 * configuration and pages that are not indexable (if the 'xml-sitemap-indexable' configuration value is set
	 * to true).
	 *
	 * @param Pages $pages
	 *   The pages collection the filter operates on.
	 *
	 * @return Pages
	 *   The filtered pages collection.
	 */
	public static function defaultFilter(Pages $pages)
	{
		$exclude = C::get('xml-sitemap-exclude', []);
		$pages = $pages->without(array_merge([C::get('error', 'error')]), $exclude);

		if (C::get('xml-sitemap-indexable', false)) {
			$pages = $pages->filterBy('indexable', '==', '1');
		}

		return $pages;
	}
}
