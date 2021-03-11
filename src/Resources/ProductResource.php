<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Product;
use RackbeatSDK\Resources\Filters\ItemFilters;

class ProductResource extends CrudResource
{
	use ItemFilters;

	protected const MODEL         = Product::class;
	protected const RESOURCE_KEY  = 'product';
	protected const ENDPOINT_BASE = 'products';

	protected function formatKeyForRequest( $key ): string
	{
		return rawurlencode( $key );
	}
}