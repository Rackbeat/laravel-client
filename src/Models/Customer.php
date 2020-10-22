<?php

namespace RackbeatSDK\Models;

/**
 * @property int            $number
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class Customer extends Model
{
	protected array $casts = [
	];
}