<?php

namespace Tests\Mocking;

use RackbeatSDK\API;

class TestController
{
	public function sendApiCall( $method, $uri )
	{
		return API::http()->call( $method, $uri );
	}
}