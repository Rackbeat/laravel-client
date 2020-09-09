<?php

namespace Rackbeat;

use Rackbeat\Http\HttpEngine;

class Rackbeat
{
	/** @var HttpEngine */
	protected static $httpEngine;

	public static function mock(): MockRackbeat
	{
		return MockRackbeat::make();
	}

	public static function make(): Rackbeat
	{
		if ( empty( self::$httpEngine ) ) {
			self::$httpEngine = new HttpEngine( [
				'base_uri' => '$baseUri',
				'headers'  => '$headers'
			] );
		}
	}

	public function http(): HttpEngine
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