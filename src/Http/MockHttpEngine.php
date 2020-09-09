<?php

namespace Rackbeat\Http;

class MockHttpEngine extends HttpEngine
{
	public static array $callsMade   = [];
	public static array $mockedCalls = [];

	public function call( $method, $uri, $options = [] )
	{
		$response = self::$mockedCalls[ $method . $uri ] ?? '';

		self::$callsMade[] = [
			'method'   => $method,
			'uri'      => $uri,
			'options'  => $options,
			'response' => $response,
		];

		return $response;
	}

	public function __destruct()
	{
		self::$callsMade = [];
		self::$mockedCalls = [];
	}

	public static function getCallsMade(): array
	{
		return self::$callsMade;
	}

	public static function calledCount( $method, $uri ): int
	{
		return \count( array_filter( self::getCallsMade(), function ( $call ) use ( $method, $uri ) {
			return $call['method'] === $method &&
			       $call['uri'] === $uri;
		} ) );
	}
}