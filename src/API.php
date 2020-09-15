<?php

namespace RackbeatSDK;

use RackbeatSDK\Concerns\Mocking;
use RackbeatSDK\Exceptions\Client\UserAgentRequiredException;
use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Http\MockHttpEngine;
use RackbeatSDK\Resources\LotResource;

class API
{
	use Mocking;

	/** @var HttpEngine|MockHttpEngine */
	protected static $httpEngine;

	public static function make( $apiToken = null ): API
	{
		if ( empty( config( 'rackbeat.consumer.name' ) ) || empty( config( 'rackbeat.consumer.email' ) ) ) {
			throw new UserAgentRequiredException( 'You must specify an consumer name and contact for validation.' );
		}

		$headers = [
			'User-Agent'         => config( 'rackbeat.consumer.name' ) . '(' . config( 'rackbeat.consumer.email' ) . ')',
			'Content-Type'       => 'application/json; charset=utf8',
			'Accept'             => 'application/json; charset=utf8',
			'API-Version'        => config( 'rackbeat.version' ),
			'X-Consumer-Name'    => config( 'rackbeat.consumer.name' ),
			'X-Consumer-Contact' => config( 'rackbeat.consumer.email' ),
		];

		if ( ! empty( $apiToken ) ) {
			$headers['Authorization'] = 'Bearer ' . $apiToken;
		} elseif ( ! empty( config( 'rackbeat.api_token' ) ) ) {
			$headers['Authorization'] = 'Bearer ' . config( 'rackbeat.api_token' );
		}

		self::$httpEngine = new HttpEngine( [
			'base_uri' => config( 'rackbeat.base_uri' ),
			'headers'  => $headers
		] );

		return new self;
	}

	public static function mock(): API
	{
		self::$httpEngine = new MockHttpEngine();

		return new self;
	}

	public static function mockResponse( $method, $uri, $response )
	{
		MockHttpEngine::mockResponse( $method, $uri, $response );
	}

	public static function http(): HttpEngine
	{
		return self::$httpEngine;
	}

	public function setApiToken( $apiToken = null )
	{
		$this->httpEngine->mergeConfig( [
			'headers' => [
				'Authorization' => 'Bearer ' . $apiToken
			]
		] );
	}

	public function lots()
	{
		return new LotResource( $this->httpEngine );
	}
}