<?php

namespace RackbeatSDK\Http;

use GuzzleHttp\Client as GuzzleHttp;
use Rackbeat\Http\Traits\HandlesJson;

class HttpEngine
{
	use HandlesJson;

	protected $client;

	public function __construct( $config = [] ) {
		$this->setupClient( $config );
	}

	protected function setupClient( $config = [] ) {
		$this->client = new GuzzleHttp( array_merge( [
			'headers' => [
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
				'User-Agent'   => 'rackbeat-php',
			]
		], $config ) );
	}

	public function post( $uri, $data ) {
		return $this->call( Method::POST, $uri, $data );
	}

	public function get( $uri, $data ) {
		return $this->call( Method::GET, $uri, $data );
	}

	public function put( $uri, $data ) {
		return $this->call( Method::PUT, $uri, $data );
	}

	public function delete( $uri, $data ) {
		return $this->call( Method::DELETE, $uri, $data );
	}

	public function head( $uri, $data ) {
		return $this->call( Method::HEAD, $uri, $data );
	}

	public function call( $method, $uri, $options = [] ) {
		return $this->getContentFromJson(
			$this->client->request( $method, $uri, $options )
		);
	}

	public function mergeConfig( $config = [] ) {
		$this->setupClient( array_merge( $this->config, $config ) );
	}
}