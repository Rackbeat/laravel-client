<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\API;
use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Models\OrderShipment;
use RackbeatSDK\Resources\Traits\CanFind;
use RackbeatSDK\Resources\Traits\CanIndex;

class OrderShipmentForOrderResource extends OrderShipmentResource
{
	public function __construct( int $orderNumber, ?HttpEngine $httpEngine = null )
	{
		parent::__construct( $httpEngine );

		$this->urlOverrides['index'] = 'orders/' . $orderNumber . '/shipments';
	}
}