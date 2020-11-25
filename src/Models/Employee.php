<?php

namespace RackbeatSDK\Models;

/**
 * @property int                $number
 * @property string             $name
 * @property string             $initials
 * @property string             $contact_phone
 * @property string             $contact_email
 * @property string             $locale
 * @property string             $job_title
 * @property boolean            $should_notify
 * @property null|int           $default_location_id
 * @property-read null|Location $default_location
 * @property-read \DateTime     $created_at
 * @property-read \DateTime     $updated_at
 * @property-read string        $self
 */
class Employee extends Model
{
	protected string $primaryKey = 'number';

	protected array $casts = [
		'number'              => 'int',
		'name'                => 'string',
		'initials'            => 'string',
		'contact_phone'       => 'string',
		'contact_email'       => 'string',
		'locale'              => 'string',
		'job_title'           => 'string',
		'should_notify'       => 'boolean',
		'default_location'    => Location::class,
		'default_location_id' => 'int',
	];
}