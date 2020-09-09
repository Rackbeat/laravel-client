<?php

use PHPUnit\Framework\TestCase;

class MockTests extends TestCase
{
	/** @test */
	public function it_can_assert_an_api_endpoint_has_been_called()
	{
		\Rackbeat\Rackbeat::mock()->assertNotCalled( 'GET', '/hi' );

		\Rackbeat\Rackbeat::mock()->http()->call( 'GET', '/hi' );

		\Rackbeat\Rackbeat::mock()->assertCalled( 'GET', '/hi' );
	}
}
