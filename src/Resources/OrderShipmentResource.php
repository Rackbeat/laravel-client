<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\API;
use RackbeatSDK\Models\OrderShipment;
use RackbeatSDK\Resources\Traits\CanFind;
use RackbeatSDK\Resources\Traits\CanIndex;

class OrderShipmentResource extends BaseResource
{
	use CanIndex, CanFind;

	protected const MODEL         = OrderShipment::class;
	protected const RESOURCE_KEY  = 'order_shipment';
	protected const ENDPOINT_BASE = 'order-shipments';

	public function shipped(): OrderShipmentResource
	{
		$this->where( 'is_shipped', true );

		return $this;
	}

	public function downloadDeliveryNote( OrderShipment $orderShipment ): string
	{
		return API::http()->post(
			'orders/shipments/' . $orderShipment->id . '/download-delivery-note',
			[]
		)->getContent();
	}

	public function downloadPickingList( OrderShipment $orderShipment ): string
	{
		return API::http()->post(
			'orders/shipments/' . $orderShipment->id . '/download',
			[]
		)->getContent();
	}
}