<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\FieldResource;

/**
 * @property-read int       $id
 * @property string         $slug
 * @property string         $name
 * @property string         $type
 * @property string         $available_for
 * @property boolean        $use_in_layouts
 * @property string         $default_value
 * @property array          $options
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class Field extends Model
{
	protected static string $RESOURCE = FieldResource::class;

	protected string $primaryKey = 'slug';

	protected array $casts = [
		'slug'           => 'string',
		'name'           => 'string',
		'type'           => 'string',
		'available_for'  => 'string',
		'use_in_layouts' => 'boolean',
		'default_value'  => 'string',
		'options'        => 'array',
	];
}