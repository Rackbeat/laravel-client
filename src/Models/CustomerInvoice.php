<?php

namespace RackbeatSDK\Models;

/**
 * @property int             $number
 * @property-read null|Order $order
 * @property-read \DateTime  $created_at
 * @property-read \DateTime  $updated_at
 * @property-read string     $self
 */
class CustomerInvoice extends Model
{
	protected array $casts = [
		'order' => Order::class,
	];
}