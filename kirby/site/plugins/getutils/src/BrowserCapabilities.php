<?php

namespace GetUtils;

use Detection\MobileDetect;


/**
 * This class provides a map of commonly used browser capability checks based on http://caniuse.com in combination
 * with the mobiledetect library.
 */
class BrowserCapabilities
{
	/**
	 * @var MobileDetect
	 */
	protected $device;

	/**
	 * @var array
	 */
	protected $capabilities;

	public function __construct()
	{
		$this->device = new MobileDetect();
	}

	/**
	 * Gets all currently supported browser capabilities in a nice array.
	 *
	 * @param string $prefix
	 *   Prefix to prepend to the array keys.
	 *
	 * @return array
	 *   A map of capabilities to true/false values.
	 */
	public function getAllCapabilities($prefix = '')
	{
		return [
			$prefix . 'background-attachment-fixed' => $this->backgroundAttachmentFixed(),
		];
	}

	/**
	 * See http://caniuse.com/#feat=background-attachment
	 */
	public function backgroundAttachmentFixed()
	{
		return !($this->device->isiOS() || $this->device->isAndroidOS());
	}
}
