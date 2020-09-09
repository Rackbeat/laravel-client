<?php

namespace Rackbeat\Concerns;

use PHPUnit\Framework\Assert as PHPUnit;
use Rackbeat\Http\MockHttpEngine;
use Rackbeat\API;

trait Mocking
{
	public static function assertCalled( $method, $uri, $count = 1 )
	{
		self::ensureHasStartedMocking();

		PHPUnit::assertEquals(
			$count,
			API::$httpEngine::calledCount( $method, $uri ),
			"The expected [{$method} {$uri}] was not called {$count} times."
		);
	}

	public static function assertNotCalled( $method, $uri )
	{
		self::assertCalled($method, $uri, 0);
	}

	public static function assertCalledMorethanOrEqualTo( $method, $uri, $count = 1 )
	{
		self::ensureHasStartedMocking();

		PHPUnit::assertGreaterThanOrEqual(
			$count,
			API::$httpEngine::calledCount( $method, $uri ),
			"The expected [{$method} {$uri}] was not called more than or equal to {$count} times."
		);
	}

	private static function ensureHasStartedMocking()
	{
		if ( empty( API::$httpEngine ) ) {
			API::$httpEngine = new MockHttpEngine();
		}

		if ( ! API::$httpEngine instanceof MockHttpEngine ) {
			throw new \Exception( 'Cannot use assertions without a MockHttpEngine set. Please call API::mock() first.' );
		}
	}
}