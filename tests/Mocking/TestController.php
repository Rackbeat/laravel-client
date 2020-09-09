<?php

namespace Tests\Mocking;

use Rackbeat\API;

class TestController
{
	public function sendApiCall( $method, $uri )
	{
		return API::http()->call( $method, $uri );
	}
}