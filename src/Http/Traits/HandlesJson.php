<?php

namespace Rackbeat\RackbeatSDK\Http\Traits;

use GuzzleHttp\Psr7\Response;

trait HandlesJson
{
	public function getJson( $uri, $json = [], $data = [] ) {
		return $this->callWithJsonBody( Method::GET, $uri, $json, $data );
	}

	public function postJson( $uri, $json = [], $data = [] ) {
		return $this->callWithJsonBody( Method::POST, $uri, $json, $data );
	}

	public function putJson( $uri, $json = [], $data = [] ) {
		return $this->callWithJsonBody( Method::PUT, $uri, $json, $data );
	}

	public function deleteJson( $uri, $json = [], $data = [] ) {
		return $this->callWithJsonBody( Method::DELETE, $uri, $json, $data );
	}

	public function headJson( $uri, $json = [], $data = [] ) {
		return $this->callWithJsonBody( Method::HEAD, $uri, $json, $data );
	}

	protected function callWithJsonBody( $method, $uri, $json = [], $data = [] ) {
		return $this->call( $method, $uri, array_merge( [ 'json' => $json ], $data ) );
	}

	public function getContentFromJson( Response $response ) {
		return json_decode( $response->getBody()->getContents() );
	}
}