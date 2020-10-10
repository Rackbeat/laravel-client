<?php

namespace RackbeatSDK;

use Illuminate\Support\Str;
use RackbeatSDK\Concerns\Mocking;
use RackbeatSDK\Exceptions\Client\UserAgentRequiredException;
use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Http\MockHttpEngine;
use RackbeatSDK\Resources\FieldResource;
use RackbeatSDK\Resources\ItemResource;
use RackbeatSDK\Resources\LotResource;
use RackbeatSDK\Resources\ProductResource;

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
			'API-Version'        => config( 'rackbeat.version' ),
			'X-Consumer-Name'    => config( 'rackbeat.consumer.name' ),
			'X-Consumer-Contact' => config( 'rackbeat.consumer.email' ),
			'Content-Type'       => 'application/json; charset=utf8',
			'Accept'             => 'application/json; charset=utf8',
			'connect_timeout'    => 5,
			'timeout'            => 90
		];

		if ( ! empty( $apiToken ) ) {
			$headers['Authorization'] = 'Bearer ' . $apiToken;
		} elseif ( ! empty( config( 'rackbeat.api_token' ) ) ) {
			$headers['Authorization'] = 'Bearer ' . config( 'rackbeat.api_token' );
		}

		self::$httpEngine = new HttpEngine( [
			'base_uri' => Str::finish(config( 'rackbeat.base_uri' ), '/'),
			'headers'  => $headers
		] );

		return new self;
	}

	public static function mock(): API
	{
		self::$httpEngine = new MockHttpEngine();

		return new self;
	}

	public static function mockResponse( $method, $uri, $response, $statusCode = 200 )
	{
		MockHttpEngine::mockResponse( $method, $uri, $statusCode, $response );
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

	public function users()
	{
		return new ItemResource();
	}

	public function items()
	{
		return new ItemResource();
	}

	public function lots()
	{
		return new LotResource();
	}

	public function products()
	{
		return new ProductResource();
	}

	public function fields()
	{
		return new FieldResource();
	}
}