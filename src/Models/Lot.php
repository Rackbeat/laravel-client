<?php

namespace Rackbeat\Models;

/**
 * @property string         number
 * @property string         name
 * @property-read \DateTime created_at
 * @property-read \DateTime updated_at
 */
class Lot extends Model
{
	protected $primaryKey = 'number';

	protected $casts = [
		'number'             => 'string',
		'urlfriendly_number' => 'string',
		'created_at'         => 'datetime',
		'updated_at'         => 'datetime',
	];
}