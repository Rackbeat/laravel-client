<?php

namespace Rackbeat;

use Rackbeat\Concerns\Mocking;
use Rackbeat\Http\HttpEngine;
use Rackbeat\Http\MockHttpEngine;

class API
{
	use Mocking;

	/** @var HttpEngine|MockHttpEngine */
	protected static $httpEngine;

	public static function make(): API
	{
		self::$httpEngine = new HttpEngine( [
			'base_uri' => '',
			'headers'  => []
		] );

		return new self;
	}

	public static function mock(): API
	{
		self::$httpEngine = new MockHttpEngine();

		return new self;
	}

	public function __destruct()
	{
		self::$httpEngine = null;
	}

	public static function http(): HttpEngine
	{
		return self::$httpEngine;
	}

	public function setConsumer( $name, $contact )
	{
		$this->httpEngine->mergeConfig( [
			'headers' => [
				'X-Consumer-Name'    => $name,
				'X-Consumer-Contact' => $contact,
			]
		] );
	}

	public function setApiToken( $apiToken = null )
	{
		$this->httpEngine->mergeConfig( [
			'headers' => [
				'Authorization' => 'Bearer ' . $apiToken
			]
		] );
	}
}