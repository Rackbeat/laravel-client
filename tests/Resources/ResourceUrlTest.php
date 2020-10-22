<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use RackbeatSDK\Resources\OrderLineResource;

class ResourceUrlTest extends TestCase
{
	/** @test */
	public function can_use_url_replacements()
	{
		$resource = new OrderLineResource( 12345 );

		$this->assertEquals( 'orders/12345/lines', $resource->getIndexUrl() );
		$this->assertEquals( 'orders/12345/lines', $resource->getStoreUrl() );
		$this->assertEquals( 'orders/12345/lines/1', $resource->getDeleteUrl( 1 ) );
		$this->assertEquals( 'orders/12345/lines/1', $resource->getShowUrl( 1 ) );
		$this->assertEquals( 'orders/12345/lines/1', $resource->getUpdateUrl( 1 ) );
	}
}
