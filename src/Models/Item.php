<?php

namespace RackbeatSDK\Models;

/**
 * @property string         number
 * @property string         name
 * @property-read \DateTime created_at
 * @property-read \DateTime updated_at
 */
class Item extends Model
{
	protected string $primaryKey = 'number';
	protected string $keyType    = 'string';

	protected array $casts = [
		'number'             => 'string',
		'urlfriendly_number' => 'string',
		'created_at'         => 'datetime',
		'updated_at'         => 'datetime',
	];
}