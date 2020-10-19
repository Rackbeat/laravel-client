<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\OrderLineResource;

/**
 * @property int            $number
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class Order extends Model
{
	protected array $casts = [
	];

	public function lines(): OrderLineResource
	{
		return new OrderLineResource( $this->number );
	}
}