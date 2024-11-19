<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\OrderShipmentResource;

/**
 * @property int            $int
 * @property Customer       $customer
 * @property boolean        $is_picked
 * @property boolean        $is_partly_picked
 * @property boolean        $is_shipped
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class OrderShipment extends Model
{
	protected static string $RESOURCE = OrderShipmentResource::class;

	protected array $casts = [
		'customer'         => Customer::class,
		'is_picked'        => 'boolean',
		'is_partly_picked' => 'boolean',
		'is_shipped'       => 'boolean',
	];

	public function downloadDeliveryNote(): string
	{
		return ( new OrderShipmentResource )->downloadDeliveryNote( $this );
	}

	public function downloadPickingList(): string
	{
		return ( new OrderShipmentResource )->downloadPickingList( $this );
	}
}