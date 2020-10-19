<?php

namespace RackbeatSDK\Models;

/**
 * @property int            $id
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class OrderLine extends Model
{
	protected array $casts = [
	];
}