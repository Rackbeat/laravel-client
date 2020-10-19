<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Order;

class OrderResource extends CrudResource
{
	protected const MODEL         = Order::class;
	protected const RESOURCE_KEY  = 'order';
	protected const ENDPOINT_BASE = 'orders';

	public function createDraft( $data = [] )
	{
		$this->setStoreUrl( $this->getStoreUrl() . '/drafts' );

		return $this->create( $data );
	}

	public function drafts(): OrderResource
	{
		$this->where( 'is_booked', false );

		return $this;
	}

	public function booked(): OrderResource
	{
		$this->where( 'is_booked', true );

		return $this;
	}
}