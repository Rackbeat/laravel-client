<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Item;

class ItemResource extends CrudResource
{
	protected const MODEL         = Item::class;
	protected const RESOURCE_KEY  = 'item';
	protected const ENDPOINT_BASE = 'items';
}