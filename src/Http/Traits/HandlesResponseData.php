<?php

namespace RackbeatSDK\Http\Traits;

use GuzzleHttp\Psr7\Response;

trait HandlesResponseData
{
	protected function parseResponse( Response $response, $overrideContent = null )
	{
		if ( empty( $content = $overrideContent ?? $response->getBody()->getContents() ) ) {
			return $content;
		}

		switch ( $this->getContentType( $response ) ) {
			case 'application/json':
				return json_decode( $content, true, 512, JSON_THROW_ON_ERROR );
			default:
				return $content;
		}
	}

	protected function getContentType( Response $response ): string
	{
		$header = $response->getHeader( 'Content-Type' ) ?? [ 'text/plain' ];

		return mb_strtolower( $header[0] );
	}
}