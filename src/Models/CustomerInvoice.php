<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\CustomerInvoiceResource;

/**
 * @property int             $number
 * @property-read null|Order $order
 * @property-read Customer   $customer
 * @property-read \DateTime  $created_at
 * @property-read \DateTime  $updated_at
 * @property-read string     $self
 */
class CustomerInvoice extends Model
{
	protected array $casts = [
		'order'    => Order::class,
		'customer' => Customer::class,
	];

	public function pdf()
	{
		return ( new CustomerInvoiceResource )->getPdf( $this->number );
	}
}