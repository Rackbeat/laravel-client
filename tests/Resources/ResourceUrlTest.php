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

	/** @test */
	public function it_can_format_keys_differently()
	{
		// Product, lot and item resources format
		$this->assertEquals( 'products/ABC%2F123', ( new ProductResource )->getShowUrl( 'ABC/123' ) );
		$this->assertEquals( 'products/%23123', ( new ProductResource )->getShowUrl( '#123' ) );
		$this->assertEquals( 'products/AbC', ( new ProductResource )->getShowUrl( 'AbC' ) );

		$this->assertEquals( 'lots/ABC%2F123', ( new LotResource )->getShowUrl( 'ABC/123' ) );
		$this->assertEquals( 'lots/%23123', ( new LotResource )->getShowUrl( '#123' ) );
		$this->assertEquals( 'lots/AbC', ( new LotResource )->getShowUrl( 'AbC' ) );

		$this->assertEquals( 'items/ABC%2F123', ( new ItemResource )->getShowUrl( 'ABC/123' ) );
		$this->assertEquals( 'items/%23123', ( new ItemResource )->getShowUrl( '#123' ) );
		$this->assertEquals( 'items/AbC', ( new ItemResource )->getShowUrl( 'AbC' ) );

		$this->assertEquals( 'items/ABC%2F123/locations/available/1', ( new ItemLocationAvailableStockResource( 'ABC/123' ) )->getShowUrl( 1 ) );
		$this->assertEquals( 'items/%23123/locations/available/1', ( new ItemLocationAvailableStockResource( '#123' ) )->getShowUrl( 1 ) );
		$this->assertEquals( 'items/AbC/locations/available/1', ( new ItemLocationAvailableStockResource( 'AbC' ) )->getShowUrl( 1 ) );

		$this->assertEquals( 'customers/1/lineables/ABC%2F123', ( new CustomerProductResource( 1 ) )->getShowUrl( 'ABC/123' ) );
		$this->assertEquals( 'customers/1/lineables/%23123', ( new CustomerProductResource( 1 ) )->getShowUrl( '#123' ) );
		$this->assertEquals( 'customers/1/lineables/AbC', ( new CustomerProductResource( 1 ) )->getShowUrl( 'AbC' ) );
	}
}
