<?php

namespace GetUtils;

use Pages;
use Site;


/**
 * Search controller class.
 */
class SearchController
{
	/**
	 * Applies all the configured search filters to the site index and returns the resulting page collection.
	 *
	 * @param Site $site
	 *   The site to search.
	 * @param $query
	 *   The search query
	 *
	 * @return Pages
	 *   The matched and filtered search results.
	 */
	public static function search(Site $site, $query = false)
	{
		if ($query === false) {
			$query = get(SearchConfig::queryParamName());
		}

		$results = $site->index()->search($query);

		foreach (SearchConfig::filters() as $filter) {
			$results = call_user_func($filter, $results);
		}

		return $results;
	}

	/**
	 * Filters pages according to the indexable ancestor rule.
	 *
	 * @param Pages $pages
	 *   The current search matches.
	 *
	 * @return Pages
	 *   The search results after applying the indexable ancestor rule.
	 */
	public static function filterIndexable(Pages $pages)
	{
		// We process all initial search results to allow only "indexable" pages to be
		// listed as results; this means, only pages that have the 'indexable' field
		// and the (checkbox) field is set to 1.
		// Pages that don't have this field or have the field set to 0 will not appear
		// in the search results, BUT the first parent that _is_ indexable will show up
		// in their place. This allows a hierarchical content model with sub-pages that
		// are directly integrated into their parent page.
		// we create a new pages collection to hold our processed search results
		$processed = new Pages();
		// the map is used to prevent adding the same page twice to the search results
		$map = array();
		foreach ($pages as $key => $page) {
			$current = $page;
			// find the first ancestor which has the indexable field and a non-empty value
			// set for that field
			while ($current !== null && $current->indexable()->isEmpty()) {
				$current = $current->parent();
			}
			// if such an ancestor exists and has not already been added, simply add it to
			// our custom processed pages collection and also add its URL to the $map to
			// prevent duplicate search results
			if ($current !== null && !array_key_exists($current->url(), $map)) {
				$processed->append($key, $current);
				$map[$current->url()] = true;
			}
		}

		return $processed;
	}
}
