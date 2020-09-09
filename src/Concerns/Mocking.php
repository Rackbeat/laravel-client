<?php

namespace Rackbeat\Concerns;

use PHPUnit\Framework\Assert as PHPUnit;
use Rackbeat\Http\MockHttpEngine;
use Rackbeat\API;

trait Mocking
{
	public static function assertCalled( $method, $uri, $count = 1 )
	{
		PHPUnit::assertEquals(
			$count,
			MockHttpEngine::calledCount( $method, $uri ),
			"The expected [{$method} {$uri}] was not called {$count} times."
		);
	}
	public static function assertResponded( $method, $uri, $response )
	{
		PHPUnit::assertEquals(
			$response,
			MockHttpEngine::latestResponse( $method, $uri ),
			"The last [{$method} {$uri}] call did not have the correct response, or was never called."
		);
	}

	public static function assertNotCalled( $method, $uri )
	{
		self::assertCalled($method, $uri, 0);
	}

	public static function assertCalledMorethanOrEqualTo( $method, $uri, $count = 1 )
	{
		PHPUnit::assertGreaterThanOrEqual(
			$count,
			MockHttpEngine::calledCount( $method, $uri ),
			"The expected [{$method} {$uri}] was not called more than or equal to {$count} times."
		);
	}
}