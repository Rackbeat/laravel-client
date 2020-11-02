<?php

namespace RackbeatSDK\Models;

/**
 * @property int            $number
 * @property int            $parent_id
 * @property string         $name
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class Location extends Model
{
	protected array $casts = [
		'number'    => 'int',
		'name'      => 'string',
		'parent_id' => 'int',
	];
}