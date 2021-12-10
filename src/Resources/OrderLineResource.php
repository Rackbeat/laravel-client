<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\API;
use RackbeatSDK\Http\Responses\IndexResponse;
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

	public function addCollection( string $collectionNumber, float $quantity = 1.0 ): IndexResponse
	{
		return $this->requestWithCollectionResponse( function () use ( $collectionNumber, $quantity ) {
			return API::http()->post( $this->getIndexUrl() . '/add-collection', [
				'collection' => $collectionNumber,
				'quantity'   => $quantity
			] );
		} );
	}

	public function getUrlReplacements(): array
	{
		return [
			'order' => $this->orderNumber,
		];
	}
}