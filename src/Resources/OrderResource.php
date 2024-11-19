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

	public function bookOrder( Order $order, $sendMail )
	{
		return $this->requestWithSingleItemResponse( function ( $query ) use ( $order, $sendMail ) {
			$query['mail'] = [
				'send' => $sendMail
			];

			return API::http()->post( $this->getBookUrl( $order->number ), $query );
		} );
	}

	public function updateFieldValue( Order $order, int $fieldId, $value )
	{
		return $this->requestWithCollectionResponse( function () use ( $order, $fieldId, $value ) {
			return API::http()->put( 'orders/' . $order->number . '/fields', [
				'custom_fields' => [
					[
						'id'    => $fieldId,
						'value' => $value
					]
				],
			] );
		} );
	}

    public function getCreateShipmentUrl( $number ): string
    {
        return $this->urlOverrides['create_shipment'] ?? ( trim( static::ENDPOINT_BASE, '/' ) . '/' . $number . '/create-shipment' );
    }

    public function createShipmentForOrder( Order $order )
    {
        return API::http()->post( $this->getCreateShipmentUrl( $order->number ), []);
    }
}