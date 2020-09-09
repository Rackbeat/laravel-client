<?php

namespace Rackbeat;

use PHPUnit\Framework\Assert as PHPUnit;
use Rackbeat\Http\MockHttpEngine;

class MockRackbeat extends Rackbeat
{
	/** @var MockHttpEngine */
	protected static $httpEngine;

	public static function make(): MockRackbeat
	{
		if ( empty( self::$httpEngine ) ) {
			self::$httpEngine = new MockHttpEngine();
		}

		return new self;
	}

	public function http(): MockHttpEngine
	{
		return self::$httpEngine;
	}

	public function assertCalled( $method, $uri, $count = 1 )
	{
		PHPUnit::assertEquals(
			static::$httpEngine::calledCount( $method, $uri ),
			$count,
			"The expected [{$method} {$uri}] was not called {$count} times."
		);
	}

	public function assertNotCalled( $method, $uri )
	{
		PHPUnit::assertEquals(
			static::$httpEngine::calledCount( $method, $uri ),
			0,
			"The expected [{$method} {$uri}] to not be called, was called."
		);
	}

	public function assertCalledMorethanOrEqualTo( $method, $uri, $count = 1 )
	{
		PHPUnit::assertGreaterThanOrEqual(
			$count,
			self::$httpEngine::calledCount( $method, $uri ),
			"The expected [{$method} {$uri}] was not called more than or equal to {$count} times."
		);
	}
}