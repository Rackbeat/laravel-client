<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Models\ItemLocationStock;
use RackbeatSDK\Resources\Traits\CanIndex;

class ItemLocationAvailableStockResource extends BaseResource
{
	use CanIndex;

	protected string $itemNumber;

	protected const MODEL         = ItemLocationStock::class;
	protected const RESOURCE_KEY  = 'location';
	protected const ENDPOINT_BASE = 'items/{item}/locations/available';

	/**
	 * @param string $itemNumber (urlfriendly_number)
	 */
	public function __construct( string $itemNumber, ?HttpEngine $httpEngine = null )
	{
		parent::__construct( $httpEngine );

		$this->itemNumber = $itemNumber;
	}

	protected function getUrlReplacements(): array
	{
		return ['item' => rawurlencode( $this->itemNumber )];
	}
}