<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Item;
use RackbeatSDK\Resources\Traits\CanFind;
use RackbeatSDK\Resources\Traits\CanIndex;

class ItemResource extends BaseResource
{
	use CanIndex, CanFind;

	protected const MODEL         = Item::class;
	protected const RESOURCE_KEY  = 'item';
	protected const ENDPOINT_BASE = 'items';
}