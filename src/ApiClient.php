<?php

namespace Rackbeat;

use Rackbeat\Http\HttpEngine;
use Rackbeat\Resources\LotResource;

class ApiClient
{
	protected $httpEngine;

	public function __construct( $apiToken = null, $userAgent = null, $baseUri = 'https://app.rackbeat.com/api/' ) {
		if ( $userAgent === null ) {
			throw new \UserAgentRequiredException( 'You must specify an User-Agent for validation. Format as follows: [COMPANY_NAME] ([OPTIONAL_PROJECT_NAME]), [CONTACT_EMAIL]' );
		}

		$this->httpEngine = new HttpEngine( [
			'base_uri' => $baseUri,
			'headers'  => [
				'User-Agent'   => $userAgent,
				'Rackbeat-Version' => '',
				'X-Consumer-Name' => '',
				'X-Consumer-Contact' => '',
				'Content-Type' => 'application/json; charset=utf8',
			]
		] );
	}

	public function setApiToken( $apiToken = null ) {
		$this->httpEngine->mergeConfig( [
			'headers' => [
				'Authorization' => 'Bearer ' . $apiToken
			]
		] );
	}

	public function lots() {
		return new LotResource( $this->httpEngine );
	}
}