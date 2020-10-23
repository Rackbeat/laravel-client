<?php

namespace RackbeatSDK\Models;

class ProductGroup extends Model
{
	protected string $primaryKey = 'number';

	protected array $casts = [
		'number' => 'int',
		'name'   => 'string',
	];
}