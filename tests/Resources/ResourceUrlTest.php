<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use RackbeatSDK\Resources\CustomerProductResource;
use RackbeatSDK\Resources\ItemLocationAvailableStockResource;
use RackbeatSDK\Resources\ItemResource;
use RackbeatSDK\Resources\LotResource;
use RackbeatSDK\Resources\OrderLineResource;
use RackbeatSDK\Resources\ProductResource;

class ResourceUrlTest extends TestCase
{
	/** @test */
	public function it_can_use_url_replacements()
	{
		$resource = new OrderLineResource( 12345 );

		$this->assertEquals( 'orders/12345/lines', $resource->getIndexUrl() );
		$this->assertEquals( 'orders/12345/lines', $resource->getStoreUrl() );
		$this->assertEquals( 'orders/12345/lines/1', $resource->getDeleteUrl( 1 ) );
		$this->assertEquals( 'orders/12345/lines/1', $resource->getShowUrl( 1 ) );
		$this->assertEquals( 'orders/12345/lines/1', $resource->getUpdateUrl( 1 ) );
	}
}
