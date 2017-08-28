<?php

namespace Getunik\Campaign;

use C;
use Constructs\Util\Enumerable;
use Page;
use Site;


/**
 * The WidgetConfig class serves as an abstraction to extract the necessary information from the content model
 * structure and prepare it for use in a template together with JavaScript.
 */
class WidgetConfig
{
	private static $intervalTypes = [
		'none' => 1,
		'weekly' => 0.25,
		'monthly' => 1,
		'quarterly' => 3,
		'semestral' => 6,
		'yearly' => 12,
	];

	/**
	 * @var Site
	 */
	protected $site;

	/**
	 * @var Page
	 */
	protected $configPage;

	/**
	 * @var array
	 */
	protected $jsConfig;

	/**
	 * WidgetConfig constructor.
	 *
	 * @param Site $site
	 *   The Kirby site.
	 * @param Page $widgetPage
	 *   The Kirby widget page object.
	 * @param $configName
	 *   The name of the widget configuration page this configuration is based on.
	 *
	 * @throws \Exception
	 */
	public function __construct(Site $site, Page $widgetPage, $configName)
	{
		$this->site = $site;
		$this->jsConfig = [];
		$this->configPage = static::getWidgetConfigPage($configName);

		if (!$this->configPage) {
			throw new \Exception('Unable to locate widget configuration "' . $configName . '"');
		}

		if ($target = $widgetPage->thanksPage()->toPage()) {
			$this->jsConfig['thanksPageUrl'] = $target->url();
		}

		$this->jsConfig['testMode'] = C::get('widget.testMode', true) ? 'true' : 'false';
		$this->jsConfig['modules'] = array_merge(WidgetModules::defaultModules(), (new Enumerable($this->configPage->widgetModules()->toStructure()))->map([static::class, 'moduleMapper'])->toArray());
		$this->jsConfig['stylesheet'] = $this->configPage->stylesheet()->value();
		$this->jsConfig['purpose'] = array_filter([
			'stored_campaign_id' => $this->configPage->campaignId()->value(),
			'stored_campaign_subid' => $this->configPage->campaignSubId()->value(),
			'stored_rnw_purpose_text' => $this->configPage->purposeText()->value(),
		]);

		$this->jsConfig['min_amount'] = [
			'single' => $this->configPage->onetimeMinAmount()->value(),
			'recurring' => $this->configPage->recurringMinAmount()->value(),
		];

		$this->addAmountOverrides($this->configPage);
	}

	/**
	 * Adds amount option overrides to the JS configuration for the widget from the given source page (which should have
	 * 'onetimeAmounts' and/or a 'recurringAmounts' field).
	 *
	 * @param Page $source
	 */
	public function addAmountOverrides(Page $source)
	{
		if ($source->onetimeAmounts()->isNotEmpty()) {
			$this->jsConfig['amounts']['onetime'] = (new Enumerable($source->onetimeAmounts()->toStructure()))->map([static::class, 'amountMapper'])->toArray();
		}

		if ($source->recurringAmounts()->isNotEmpty()) {
			$this->jsConfig['amounts']['recurring'] = (new Enumerable($source->recurringAmounts()->toStructure()))->map([static::class, 'amountMapper'])->toArray();
		}

		if ($source->boxes()->isNotEmpty()) {
			$intervalType = $source->boxes()->toStructure()->current()->intervalType()->value();
			$factor = array_key_exists($intervalType, self::$intervalTypes) ? self::$intervalTypes[$intervalType] : 1;
			$amounts = (new Enumerable($source->boxes()->toStructure()))->map([static::class, 'amountMapper'])->map(function ($amount) use ($factor) {
				return $amount / $factor;
			})->toArray();
			$donationType = ($intervalType === 'none' ? 'onetime' : 'recurring');
			$this->jsConfig['amounts'][$donationType] = array_filter($amounts);
		}
	}

	/**
	 * Sets fallback donation purpose parameters.
	 *
	 * @param array $purpose
	 */
	public function setFallbackPurpose($purpose)
	{
		$this->jsConfig['purpose'] = array_merge($purpose, $this->jsConfig['purpose']);
	}

	/**
	 * Gets the full widget script URL.
	 *
	 * @return string
	 */
	public function url()
	{
		return implode('', [static::widgetBaseUrl(), $this->configPage->widgetConfigId()->value(), '/js/dds-init-widget-', $this->site->language()->code(), '.js']);
	}

	/**
	 * Gets the JS config parameters for the customization code.
	 *
	 * @return array
	 */
	public function jsConfig()
	{
		return $this->jsConfig;
	}

	/**
	 * Gets the raw JS user code for this widget.
	 *
	 * return string|null
	 */
	public function userCode()
	{
		return $this->configPage->customCode()->value();
	}

	/**
	 * Attempts to locate the widget configuration with the given name in the site structure.
	 *
	 * @param $configName
	 *   The name of the widget configuration to fetch.
	 *
	 * @return Page
	 */
	public static function getWidgetConfigPage($configName)
	{
		return kirby()->site()->pages()->findByURI('system/widgets/' . $configName);
	}

	/**
	 * Gets the widget base URL.
	 *
	 * @return string
	 */
	public static function widgetBaseUrl()
	{
		return C::get('widget.baseUrl', 'https://widget.raisenow.com/widgets/lema/');
	}

	/**
	 * Internal helper function (callback)
	 */
	public static function amountMapper($item)
	{
		return intval($item->amount()->value());
	}

	/**
	 * Internal helper function (callback)
	 */
	public static function moduleMapper($item)
	{
		return $item->module()->value();
	}
}
