<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\API;
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

	public function getBookUrl( $number ): string
	{
		return $this->urlOverrides['book'] ?? ( trim( static::ENDPOINT_BASE, '/' ) . '/' . $number . '/book' );
	}

	public function bookOrder( Order $order )
	{
		return $this->requestWithSingleItemResponse( function ( $query ) use ( $order ) {
			return API::http()->post( $this->getBookUrl( $order->number ), $query );
		} );
	}
}