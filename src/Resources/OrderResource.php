<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Field;
use RackbeatSDK\Models\Order;

class OrderResource extends CrudResource
{
	protected const MODEL         = Order::class;
	protected const RESOURCE_KEY  = 'order';
	protected const ENDPOINT_BASE = 'orders';
}