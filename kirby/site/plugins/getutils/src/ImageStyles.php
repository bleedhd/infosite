<?php

namespace GetUtils;

use a;
use c;
use GetUtils\Assets\KirbyJs;


class ImageStyles
{
	public static function getBreakpoints()
	{
		return c::get('image-style.breakpoints', ['xs', 'sm', 'md', 'lg', 'xl']);
	}

	public static function getStyleDefinitions()
	{
		return c::get('image-style.definitions', []);
	}

	public static function getBreakpointAttr($breakpoint)
	{
		return c::get('image-style.attr-prefix', 'data-src-') . $breakpoint;
	}

	public static function getDefaultClass()
	{
		return c::get('image-style.default-class', 'img-responsive');
	}

	public static function getDataAttributes($file, $imageStyle)
	{
		$attributes = [];

		$imageStyleConfig = a::get(static::getStyleDefinitions(), $imageStyle, []);
		$alternatives = [];
		foreach ($file->responsive()->toStructure() as $breakpoint) {
			$alternatives[$breakpoint->breakpoint()->toString()] = $breakpoint->image()->toFile();
		}

		$currentFile = $file;
		$currentDefinition = NULL;
		$currentUrl = NULL;
		$previousUrl = NULL;

		foreach (static::getBreakpoints() as $breakpoint) {
			if (isset($alternatives[$breakpoint])) {
				$currentFile = $alternatives[$breakpoint];
			}
			if (isset($imageStyleConfig[$breakpoint])) {
				$currentDefinition = $imageStyleConfig[$breakpoint];
			}

			$currentUrl = $currentDefinition === NULL ? $currentFile->url() :  thumb($currentFile, $currentDefinition)->url();
			// only add another source attribute if it differs from the previous one;
			// this assumes that the JS code that loads the proper source is using the same breakpoint order.
			if ($currentUrl !== $previousUrl) {
				$attributes[static::getBreakpointAttr($breakpoint)] = $currentUrl;
				$previousUrl = $currentUrl;
			}
		}

		return new Attributes($attributes);
	}

	public static function registerJsUtils(KirbyJs $kirbyjs)
	{
		$kirbyjs->registerConstant('ResponsiveImages', [
			'map' => [],
			'order' => static::getBreakpoints(),
		]);
	}
}
