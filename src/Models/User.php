<?php

namespace RackbeatSDK\Models;

/**
 * @property-read int       $id
 * @property string         $name
 * @property string         $billing_type
 * @property string         $initials
 * @property string         $avatar
 * @property string         $email
 * @property string         $locale
 * @property boolean        $is_you
 * @property boolean        $is_api_only
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
		'is_api_only'  => 'boolean',
		'employee_id'  => 'int',
		//		'employee'     => Employee::class,
		'permissions'  => 'object', // todo use model-objects?
		'settings'     => 'object', // todo use model-objects?
	];
}