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

	protected array $config;

	public function __construct( $config = [] )
	{
		$this->setupClient( $config );
	}

	protected function setupClient( $config = [] )
	{
		$this->config = array_merge( [
			'headers' => [
				'Content-Type'    => 'application/json; charset=utf8',
				'Accept'          => 'application/json; charset=utf8',
				'User-Agent'      => 'rackbeat-php',
				'connect_timeout' => 5,
				'timeout'         => 90
			]
		], $config );

		$this->client = new GuzzleHttp( $this->config );
	}

	public function post( $uri, $data )
	{
		return $this->call( Method::POST, $uri, $data );
	}

	public function get( $uri, $data )
	{
		return $this->call( Method::GET, $uri, $data );
	}

	public function put( $uri, $data )
	{
		return $this->call( Method::PUT, $uri, $data );
	}

	public function delete( $uri, $data )
	{
		return $this->call( Method::DELETE, $uri, $data );
	}

	public function head( $uri, $data )
	{
		return $this->call( Method::HEAD, $uri, $data );
	}

	public function call( $method, $uri, $options = [] )
	{
		try {
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
}