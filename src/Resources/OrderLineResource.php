<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\OrderLine;

class OrderLineResource extends CrudResource
{
	protected int $orderNumber;

	protected const MODEL         = OrderLine::class;
	protected const RESOURCE_KEY  = 'order_line';
	protected const ENDPOINT_BASE = 'order_lines';

	public function __construct( int $orderNumber )
	{
		parent::__construct();

		$this->orderNumber = $orderNumber;
	}

	public function getIndexUrl(): string
	{
		return 'orders/' . $this->orderNumber . '/lines';
	}

	public function getShowUrl( $id ): string
	{
		return 'orders/' . $this->orderNumber . '/lines/' . $id;
	}
}