<?php

namespace RackbeatSDK\Models;

/**
 * @property string         $number
 * @property string         $name
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 */
class User extends Model
{
	protected array $casts = [
		'name'         => 'string',
		'billing_type' => 'string',
		'initials'     => 'string',
		'avatar'       => 'string',
		'email'        => 'string',
		'locale'       => 'string',
		'is_you'       => 'boolean',
		'employee_id'  => 'int',
//		'employee'     => Employee::class,
		'permissions'  => 'object',
		'settings'     => 'object',
	];
}