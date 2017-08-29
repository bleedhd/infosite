<?php

namespace GetUtils;

use C;


/**
 * Configuration object for the search functionality. Contains centralized handling of configuration default values
 * and configuration processing.
 */
class SearchConfig
{
	/**
	 * Parameter name for the search query.
	 *
	 * @return string
	 */
	public static function queryParamName()
	{
		return C::get('search-param-name', 'q');
	}

	/**
	 * Flag for enabling 'indexable' field feature.
	 *
	 * @return bool
	 */
	public static function useIndexable()
	{
		return C::get('search-indexable', false);
	}

	/**
	 * Gets an array of all configured search filters (callables).
	 *
	 * @return array
	 */
	public static function filters()
	{
		$filters = C::get('search-filters-override', NULL);

		if ($filters === NULL) {
			$filters = [];

			if (static::useIndexable()) {
				$filters[] = [SearchController::class, 'filterIndexable'];
			}

			$filters = array_merge($filters, C::get('search-filters', []));
		}

		return $filters;
	}

	/**
	 * Search API path.
	 *
	 * @return string
	 */
	public static function apiPath()
	{
		return C::get('search-api-path', 'search');
	}

	/**
	 * Flag for enabling the search (JSON) API.
	 *
	 * @return bool
	 */
	public static function apiEnabled()
	{
		return C::get('search-api-enabled', false);
	}

	/**
	 * Fields that will be included in API search results.
	 *
	 * @return array
	 */
	public static function apiFields()
	{
		return C::get('search-api-fields', ['id', 'url', 'uid', 'title']);
	}
}
