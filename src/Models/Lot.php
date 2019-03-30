<?php

namespace Rackbeat\Models;

/**
 * @property string         number
 * @property string         name
 * @property-read \DateTime created_at
 * @property-read \DateTime updated_at
 */
class Lot extends BaseModel
{
	protected $casts = [
		'number'     => 'string',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];
}