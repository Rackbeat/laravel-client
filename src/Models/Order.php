<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Exceptions\Models\Orders\OrderAlreadyBookedException;
use RackbeatSDK\Models\Objects\AddressObject;
use RackbeatSDK\Resources\OrderLineResource;
use RackbeatSDK\Resources\OrderResource;

/**
 * @property int                $number
 * @property Customer           $customer
 * @property boolean            $is_archived
 * @property boolean            $is_booked
 * @property boolean            $is_cancelled
 * @property boolean            $is_shipped
 * @property boolean            $is_ready_for_shipping
 * @property boolean            $is_partly_shipped
 * @property boolean            $is_ready_for_invoicing
 * @property boolean            $is_invoiced
 * @property boolean            $is_partly_invoiced
 * @property boolean            $is_ready_for_purchasing
 * @property boolean            $is_partly_purchased
 * @property-read null|Employee $our_reference
 * @property AddressObject      $billing_address
 * @property AddressObject      $delivery_address
 * @property null|\DateTime     $deliver_at
 * @property-read \DateTime     $created_at
 * @property-read \DateTime     $updated_at
 * @property-read string        $self
 */
class Order extends Model
{
	protected static string $RESOURCE = OrderResource::class;

	protected string $primaryKey = 'number';

	protected array $casts = [
		'customer'                => Customer::class,
		'payment_terms'           => PaymentTerm::class,
		'is_archived'             => 'boolean',
		'is_booked'               => 'boolean',
		'is_cancelled'            => 'boolean',
		'is_shipped'              => 'boolean',
		'is_ready_for_shipping'   => 'boolean',
		'is_partly_shipped'       => 'boolean',
		'is_ready_for_invoicing'  => 'boolean',
		'is_invoiced'             => 'boolean',
		'is_partly_invoiced'      => 'boolean',
		'is_ready_for_purchasing' => 'boolean',
		'is_partly_purchased'     => 'boolean',
		'deliver_at'              => 'datetime',
		'our_reference'           => Employee::class,
		'billing_address'         => AddressObject::class,
		'delivery_address'        => AddressObject::class,
	];

	public function lines(): OrderLineResource
	{
		return new OrderLineResource( $this->number );
	}

	public function book( $sendMail = false )
	{
		if ( $this->is_booked ) {
			throw new OrderAlreadyBookedException( 'The order ' . $this->number . ' is already booked.' );
		}

		$this->overrideDataFromModel(
			( new OrderResource )->bookOrder( $this, $sendMail )
		);

		return $this;
	}
}