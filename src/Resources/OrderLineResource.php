<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\OrderLine;

class OrderLineResource extends CrudResource
{
	protected int $orderNumber;

	protected const MODEL         = OrderLine::class;
	protected const RESOURCE_KEY  = 'order_line';
	protected const ENDPOINT_BASE = 'orders/{order}/lines';

	public function __construct( int $orderNumber )
	{
		parent::__construct();

		$this->orderNumber = $orderNumber;
	}

	public function getUrlReplacements(): array
	{
		return [
			'order' => $this->orderNumber,
		];
	}
}