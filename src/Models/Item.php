<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\ItemLocationAvailableStockResource;

/**
 * @property string         $type
 * @property string         $number
 * @property string         $name
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 */
class Item extends Model
{
	protected string $primaryKey = 'number';
	protected string $keyType    = 'string';

	protected array $casts = [
		'type'               => 'string',
		'number'             => 'string',
		'urlfriendly_number' => 'string',
		'created_at'         => 'datetime',
		'updated_at'         => 'datetime',
	];

	public function availableLocationStockReport()
	{
		return new ItemLocationAvailableStockResource( $this->urlfriendly_number );
	}
}