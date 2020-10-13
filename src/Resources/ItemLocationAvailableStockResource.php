<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\ItemLocationStock;
use RackbeatSDK\Resources\Traits\CanIndex;

class ItemLocationAvailableStockResource extends BaseResource
{
	use CanIndex;

	protected string $itemNumber;

	protected const MODEL         = ItemLocationStock::class;
	protected const RESOURCE_KEY  = 'location';
	protected const ENDPOINT_BASE = 'items/{item}/locations/available';

	public function __construct( string $itemNumber )
	{
		parent::__construct();

		$this->itemNumber = $itemNumber;
	}

	public function getIndexUrl(): string
	{
		return 'items/' . $this->itemNumber . '/locations/available';
	}
}