<?php

namespace GetUtils\Assets;

use a;


class AssetManager
{
	public $bla = '42';
	private $registries = [];

	public function __construct()
	{
		$this->registries['js'] = new JsRegistry();
		$this->registries['css'] = new CssRegistry();
	}

	public function getRegistry($assetType)
	{
		$registry = a::get($this->registries, $assetType);
		if ($registry === NULL) {
			throw new \Exception('Unknown asset registry type ' . $assetType);
		}

		return $registry;
	}

	private static $inst = NULL;

	public static function instance()
	{
		if (static::$inst === NULL) {
			static::$inst = new static();
		}

		return static::$inst;
	}
}
