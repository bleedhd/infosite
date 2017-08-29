<?php

namespace GetUtils\Assets;

use Brick;
use a;


class CssRegistry extends BaseAssetRegistry
{
	protected function renderBucket(array $bucket)
	{
		$output = [];

		foreach ($bucket as $style)
		{
			$tag = new Brick('link');
			$tag->attr('rel', 'stylesheet');
			$tag->attr('href', a::get($style, 'href'));

			$output[] = $tag;
		}

		return implode(PHP_EOL, $output);
	}
}
