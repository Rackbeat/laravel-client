<?php

namespace RackbeatSDK\Models;

/**
 * @property int            $number
 * @property string         $name
 * @property  string        $type
 * @property string         $type_translated
 * @property string         $description
 * @property int            $maturity_days
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class PaymentTerm extends Model
{
	protected string $primaryKey = 'number';

	protected array $casts = [
	];
}