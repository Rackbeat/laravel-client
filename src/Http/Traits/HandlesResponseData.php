<?php

namespace RackbeatSDK\Http\Traits;

use GuzzleHttp\Psr7\Response;
use RackbeatSDK\Http\Responses\PdfResponse;

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
			case 'application/pdf':
				return new PdfResponse( $content );
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