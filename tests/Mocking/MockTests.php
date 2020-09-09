<?php

namespace Tests\Mocking;

use PHPUnit\Framework\TestCase;

class MockTests extends TestCase
{
	/** @test */
	public function it_can_assert_an_api_endpoint_has_been_called()
	{
		\Rackbeat\API::mock();
		\Rackbeat\API::assertNotCalled( 'GET', '/hi' );

		\Rackbeat\API::http()->call( 'GET', '/hi' );

		\Rackbeat\API::assertCalled( 'GET', '/hi' );
	}

	/** @test */
	public function it_remembers_called_endpoints_even_if_made_through_other_classes_such_as_a_controller()
	{
		\Rackbeat\API::mock();
		\Rackbeat\API::assertNotCalled( 'POST', '/test' );

		( new TestController() )->sendApiCall( 'POST', '/test' );

		\Rackbeat\API::assertCalled( 'POST', '/test' );
	}
}
