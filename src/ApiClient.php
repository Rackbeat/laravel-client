<?php

namespace Rackbeat;

use Rackbeat\Http\HttpEngine;
use Rackbeat\Http\MockHttpEngine;
use Rackbeat\Resources\LotResource;

class ApiClient
{
	protected $httpEngine;
	protected static $test;

	public function __construct( string $apiToken, array $consumer, string $rackbeatVersion = 'latest', string $baseUri = 'https://app.rackbeat.com/api/' )
	{
		if ( ! isset( $consumer['name'], $consumer['contact'] ) ) {
			throw new \UserAgentRequiredException( 'You must specify an consumer name and contact for validation.' );
		}

		$headers = [
			'User-Agent'         => $consumer['name'] . '(' . $consumer['contact'] . ')',
			'Content-Type'       => 'application/json; charset=utf8',
			'Rackbeat-Version'   => $rackbeatVersion,
			'X-Consumer-Name'    => $consumer['name'],
			'X-Consumer-Contact' => $consumer['contact'],
		];

		if ( ! empty( $apiToken ) ) {
			$headers['Authorization'] = 'Bearer ' . $apiToken;
		}

		$this->httpEngine = new HttpEngine( [
			'base_uri' => $baseUri,
			'headers'  => $headers
		] );
	}

	public static function mock(): ApiClient
	{
		$client = ( new self( 'mocking', [ 'name' => 'Mock', 'contact' => 'Mock' ] ) );

		$client->httpEngine = new MockHttpEngine();

		return $client;
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

	public function lots()
	{
		return new LotResource( $this->httpEngine );
	}
}