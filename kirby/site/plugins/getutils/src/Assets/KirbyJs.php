<?php

namespace GetUtils\Assets;


class KirbyJs
{
	public static $instance;

	/**
	 * Singleton implementation.
	 *
	 * @return KirbyJs
	 */
	public static function instance()
	{
		if (!is_null(static::$instance)) {
			return static::$instance;
		}
		return static::$instance = new static();
	}

	protected $kirbyJsFile;
	protected $constants = [];
	protected $utils = [];

	public function __construct()
	{
		$this->kirbyJsFile = realpath(implode(DS, [__DIR__, '..', '..', 'assets', 'kirby.js.php']));
	}

	/**
	 * @param string $name
	 *   Name of the constant to register.
	 * @param mixed $value
	 *   Value of the constant to register.
	 *
	 * @return KirbyJs
	 */
	public function registerConstant($name, $value)
	{
		$this->constants[$name] = $value;
		return $this;
	}

	/**
	 * @param array $constants
	 *   The constants (key > name, value > value) to register.
	 *
	 * @return KirbyJs
	 */
	public function registerConstants(array $constants)
	{
		$this->constants = array_merge($this->constants, $constants);
		return $this;
	}

	/**
	 * @param $name
	 *   Name of the utility to register.
	 * @param $utilPath
	 *   Path to the utility JS (or JS/PHP) file.
	 * @param array $data
	 *   Additional data for the JS/PHP file.
	 *
	 * @return KirbyJs
	 */
	public function registerUtil($name, $utilPath, $data = [])
	{
		$this->utils[$name] = [
			'file' => $utilPath,
			'data' => $data,
		];
		return $this;
	}

	/**
	 * @return bool|string
	 */
	public function render()
	{
		return static::load($this->kirbyJsFile, [
			'constants' => $this->constants,
			'utils' => $this->processUtils(),
		]);
	}

	protected function processUtils()
	{
		return array_map(function ($util) {
			return static::load($util['file'], $util['data']);
		}, $this->utils);
	}

	protected static function load($_file, $_data)
	{
		if (!file_exists($_file)) {
			return false;
		}

		ob_start();
		extract($_data);
		require($_file);
		$_content = ob_get_contents();
		ob_end_clean();

		return $_content;
	}
}
