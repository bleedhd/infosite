<?php

namespace Getunik\Campaign;

use Obj;
use S;


/**
 * Donation transaction information wrapper. Provides Kirby-style API for accessing RaiseNow payment information.
 */
class TransactionInformation extends Obj
{
	const SESSION_KEY = 'widget-transaction-information';

	/**
	 * Tracking data processing functions.
	 *
	 * @var array
	 */
	public static $trackingDataProcessors = [];

	/**
	 * Internal state to prevent tracking the same transaction multiple times.
	 *
	 * @var bool
	 */
	protected $isTracked = false;

	/**
	 * Retrieves a transaction from the user's session.
	 *
	 * @return TransactionInformation
	 */
	public static function getFromSession()
	{
		return S::get(static::SESSION_KEY);
	}

	/**
	 * Builds a transaction from the current request data.
	 *
	 * @return TransactionInformation
	 */
	public static function getFromRequest()
	{
		return new self($_REQUEST);
	}

	/**
	 * Stores the transaction in the user's session.
	 */
	public function storeInSession()
	{
		S::set(static::SESSION_KEY, $this);
	}

	/**
	 * Returns true if the transaction has already been tracked.
	 *
	 * @return bool
	 */
	public function isTracked()
	{
		return $this->isTracked;
	}

	/**
	 * Sets the tracked status of the transaction.
	 *
	 * @param bool $tracked
	 */
	public function setTracked($tracked = true)
	{
		$this->isTracked = $tracked;
	}

	/**
	 * Generates Google EEC tracking data from the transaction information.
	 *
	 * @param bool $setTracked
	 *   If set to true, this will also set the tracked status of the transaction.
	 *
	 * @return array|null
	 */
	public function getECommerceTrackingData($setTracked = false)
	{
		if ($this->isTracked()) {
			return NULL;
		}

		$this->setTracked($setTracked);

		$data = [
			'ecommerce' => [
				'currencyCode' => strtoupper($this->currency()),
				'purchase' => [
					'actionField' => [
						'id' => $this->epp_transaction_id(),
						'revenue' => $this->amount() / 100,
						'tax' => 0,
						'shipping' => 0,
					],
					'products' => [
						[
							'name' => $this->stored_rnw_purpose_text(),
							'id' => $this->stored_campaign_id() . ':' . $this->stored_campaign_subid(),
							'price' => $this->amount() / 100,
							'category' => ($this->recurring_interval_name() === 'default' ? 'donation' : 'subscription:' . $this->recurring_interval_name()),
							'variant' => ($this->test_mode() === 'true' ? 'Test' : 'Prod'),
							'quantity' => 1,
						]
					],
				],
			],
		];

		foreach (self::$trackingDataProcessors as $processor) {
			$processor($data, $this);
		}

		return $data;
	}
}
