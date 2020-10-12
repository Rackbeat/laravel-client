<?php

namespace RackbeatSDK\Models;

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
	protected array $casts = [
		'id'             => 'int',
		'slug'           => 'string',
		'name'           => 'string',
		'type'           => 'string',
		'available_for'  => 'string',
		'use_in_layouts' => 'boolean',
		'default_value'  => 'string',
		'options'        => 'array',
		'created_at'     => 'datetime',
		'updated_at'     => 'datetime',
		'self'           => 'string',
	];
}