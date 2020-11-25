<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\ItemLocationAvailableStockResource;

/**
 */
class ItemLocationStock extends Model
{
	protected static string $RESOURCE = ItemLocationAvailableStockResource::class;

	protected array $casts = [
	];
}