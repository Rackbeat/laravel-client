<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Collection;
use RackbeatSDK\Resources\Filters\ItemFilters;
use RackbeatSDK\Resources\Traits\CanFind;
use RackbeatSDK\Resources\Traits\CanIndex;

class CollectionResource extends BaseResource
{
	use CanIndex, CanFind, ItemFilters;

	protected const MODEL         = Collection::class;
	protected const RESOURCE_KEY  = 'collection';
	protected const ENDPOINT_BASE = 'collections';

	protected function formatKeyForRequest( $key ): string
	{
		return rawurlencode( $key );
	}
}