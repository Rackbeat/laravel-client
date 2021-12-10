<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\CollectionResource;

/**
 * @property string         $number
 * @property string         $urlfriendly_number
 * @property string         $name
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 */
class Collection extends Model
{
	protected static string $RESOURCE = CollectionResource::class;

	protected string $primaryKey = 'number';

	protected string $keyType = 'string';

	protected array $casts = [
		'number'             => 'string',
		'urlfriendly_number' => 'string',
	];
}