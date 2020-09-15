<?php

namespace Tests\Mocking;

use PHPUnit\Framework\TestCase;

class MockTests extends TestCase
{
	/** @test */
	public function it_can_assert_an_api_endpoint_has_been_called()
	{
		\RackbeatSDK\API::mock();
		\RackbeatSDK\API::assertNotCalled( 'GET', '/hi' );

		\RackbeatSDK\API::http()->call( 'GET', '/hi' );

		\RackbeatSDK\API::assertCalled( 'GET', '/hi' );
	}

	/** @test */
	public function it_remembers_called_endpoints_even_if_made_through_other_classes_such_as_a_controller()
	{
		\RackbeatSDK\API::mock();
		\RackbeatSDK\API::assertNotCalled( 'POST', '/test' );

		( new TestController() )->sendApiCall( 'POST', '/test' );

		\RackbeatSDK\API::assertCalled( 'POST', '/test' );
	}

	/** @test */
	public function it_can_mock_the_response()
	{
		\RackbeatSDK\API::mock();
		\RackbeatSDK\API::mockResponse( 'POST', '/test', json_encode( [ 'message' => 'Good job!' ] ) );

		\RackbeatSDK\API::http()->call( 'POST', '/test' );

		\RackbeatSDK\API::assertCalled( 'POST', '/test' );
		\RackbeatSDK\API::assertResponded( 'POST', '/test', json_encode( [ 'message' => 'Good job!' ] ) );
		\RackbeatSDK\API::assertRespondedStatus( 'POST', '/test', 200 );
	}
}
