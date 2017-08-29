<?php

namespace GetUtils\Assets;


abstract class BaseAssetRegistry
{
	const BUCKET_BOOTSTRAP = 1000;
	const BUCKET_DEFAULT = 2000;
	const BUCKET_POST = 3000;

	protected $assets = [];

	public function register($assetDefinition, $bucket = NULL)
	{
		$bucket = ($bucket === NULL ? static::BUCKET_DEFAULT : $bucket);
		$this->assets[$bucket][] = $assetDefinition;
	}

	public function render()
	{
		ksort($this->assets);

		$output = [];
		foreach ($this->assets as $bucket) {
			$output[] = $this->renderBucket($bucket);
		}

		return implode(PHP_EOL, $output);
	}

	protected abstract function renderBucket(array $bucket);
}
