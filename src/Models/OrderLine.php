<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\OrderLineResource;

/**
 * @property int            $id
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class OrderLine extends Model
{
	protected static string $RESOURCE = OrderLineResource::class;

	protected array $casts = [
		'unit'     => 'object',
		'location' => 'object',
		'item'     => 'object',
	];
}