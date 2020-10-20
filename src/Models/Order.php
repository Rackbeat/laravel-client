<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Exceptions\Models\Orders\OrderAlreadyBookedException;
use RackbeatSDK\Resources\OrderLineResource;
use RackbeatSDK\Resources\OrderResource;

/**
 * @property int            $number
 * @property bool           $is_booked
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

	public function book()
	{
		if ( $this->is_booked ) {
			throw new OrderAlreadyBookedException( 'The order ' . $this->number . ' is already booked.' );
		}

		$this->overrideDataFromModel(
			( new OrderResource )->bookOrder( $this )
		);

		return $this;
	}
}