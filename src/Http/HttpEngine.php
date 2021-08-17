<?php

namespace RackbeatSDK\Http;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\Exception\BadResponseException;
use RackbeatSDK\Http\Traits\HandlesErrorResponses;
use RackbeatSDK\Http\Traits\HandlesJson;
use RackbeatSDK\Http\Traits\HandlesResponseData;

class HttpEngine
{
	use HandlesResponseData, HandlesJson, HandlesErrorResponses;

	protected GuzzleHttp $client;

	/** @var array */
	protected static array $beforeHooks = [];

	protected array $config;

	public function __construct( $config = [] )
	{
		$this->setupClient( $config );
	}

	protected function setupClient( $config = [] )
	{
		$this->config = $config;

		$this->client = new GuzzleHttp( $this->config );
	}

	public function post( $uri, $data )
	{
		// todo allow post non-json
		return $this->call( Method::POST, $uri, [ 'json' => $data ] );
	}

	public function get( $uri, $query )
	{
		return $this->call( Method::GET, $uri, [ 'query' => $query ] );
	}

	public function put( $uri, $data )
	{
		return $this->call( Method::PUT, $uri, [ 'json' => $data ] );
	}

	public function delete( $uri, $options )
	{
		return $this->call( Method::DELETE, $uri, $options );
	}

	public function head( $uri, $options )
	{
		return $this->call( Method::HEAD, $uri, $options );
	}

	public function call( $method, $uri, $options = [] )
	{
		try {
			foreach ( self::$beforeHooks as $hook ) {
				$hook( $method, $uri, $options, $this->config );
			}

			return $this->parseResponse(
				$this->client->request( $method, $uri, $options )
			);
		} catch ( BadResponseException $exception ) {
			$this->throwException( $exception );
		}
	}

	public function mergeConfig( $config = [] )
	{
		$this->setupClient( array_merge( $this->config, $config ) );
	}

	public static function setBeforeHooks( array $hooks = [] )
	{
		self::$beforeHooks = $hooks;
	}
}