<?php

namespace RackbeatSDK\Models;

/**
 * @property int            $number
 * @property float|double   $general_discount_percentage
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class Customer extends Model
{
	protected array $casts = [
	];
}