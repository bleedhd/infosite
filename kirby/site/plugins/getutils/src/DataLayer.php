<?php

namespace GetUtils;


use A;
use S;


/**
 * Google Tag Manager data layer helper class. This serves as a server-side temporary store for data layer
 * events. Pushing an event onto the data layer will store it in the current user's session until the session
 * store is flushed when the data layer is rendered to the client-side.
 */
class DataLayer
{
	const SESSION_KEY = 'getu-data-layer';

	/**
	 * @param array $event
	 *   The event to push to the data layer.
	 */
	public static function push($event)
	{
		$data = S::get(static::SESSION_KEY, []);
		$data[] = $event;
		S::set(static::SESSION_KEY, $data);
	}

	/**
	 * Retrieves all events currently held in the user's session store and serializes them to a sequence of
	 * client-side data layer push events. The resulting JavaScript code is then returned. See {@see dataLayer}
	 *
	 * @return string
	 */
	public static function flush()
	{
		$data = S::pull(static::SESSION_KEY, []);

		$items = array_map(function ($item) {
			return 'dataLayer.push(' . A::json($item) . ');';
		}, $data);

		return 'var dataLayer = dataLayer || [];' . PHP_EOL . implode(PHP_EOL, $items);
	}
}
