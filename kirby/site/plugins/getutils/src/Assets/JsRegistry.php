<?php

namespace GetUtils\Assets;

use Brick;
use a;


class JsRegistry extends BaseAssetRegistry
{
	protected function renderBucket(array $bucket)
	{
		$output = [];

		foreach ($bucket as $script)
		{
			$tag = new Brick('script');
			$tag->attr('type', 'text/javascript');

			if (a::get($script, 'type') === 'inline') {
				$tag->html(a::get($script, 'content'));
			} else {
				$tag->attr('src', a::get($script, 'src', ''));
			}

			$output[] = $tag;
		}

		return implode(PHP_EOL, $output);
	}
}
