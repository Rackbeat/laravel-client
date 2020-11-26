<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\ProductGroupResource;

class ProductGroup extends Model
{
	protected string $primaryKey = 'number';

	protected static string $RESOURCE = ProductGroupResource::class;

	protected array $casts = [
		'number' => 'int',
		'name'   => 'string',
	];
}