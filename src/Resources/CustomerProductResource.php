<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Models\CustomerProduct;
use RackbeatSDK\Resources\Filters\ItemFilters;
use RackbeatSDK\Resources\Traits\CanFind;
use RackbeatSDK\Resources\Traits\CanIndex;

class CustomerProductResource extends BaseResource
{
	use CanIndex, CanFind, ItemFilters;

	protected int $customerNumber;

	protected const MODEL         = CustomerProduct::class;
	protected const RESOURCE_KEY  = 'item';
	protected const ENDPOINT_BASE = 'customers/{customer}/lineables';

	public function __construct( int $customerNumber, ?HttpEngine $httpEngine = null )
	{
		parent::__construct( $httpEngine );

		$this->customerNumber = $customerNumber;
	}

	protected function getUrlReplacements(): array
	{
		return [
			'customer' => $this->customerNumber
		];
	}

	protected function formatKeyForRequest( $key ): string
	{
		return rawurlencode( $key );
	}
}