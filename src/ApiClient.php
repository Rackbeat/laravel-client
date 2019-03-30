<?php

namespace Rackbeat;

use Rackbeat\Http\HttpEngine;

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
				'User-Agent' => $userAgent
			]
		] );
	}

	public function setApiToken($apiToken = null) {
		$this->httpEngine->mergeConfig();
	}

	public function lots() {

	}
}