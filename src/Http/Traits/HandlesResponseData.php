<?php

namespace RackbeatSDK\Http\Traits;

use GuzzleHttp\Psr7\Response;

trait HandlesResponseData
{
	protected function parseResponse( Response $response )
	{
		switch ( $this->getContentType( $response ) ) {
			case 'application/json':
				return json_decode( $response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR );
			default:
				return $response->getBody()->getContents();
		}
	}

	protected function getContentType( Response $response ): string
	{
		$header = $response->getHeader( 'Content-Type' ) ?? [ 'application/json' ];

		return mb_strtolower( $header[0] );
	}
}