<?php

namespace RackbeatSDK\Http\Traits;

use GuzzleHttp\Exception\BadResponseException;
use RackbeatSDK\Exceptions\Responses\ServerErrorException;
use RackbeatSDK\Exceptions\Responses\ThrottledResponseException;
use RackbeatSDK\Exceptions\Responses\UnauthorizedResponseException;

trait HandlesErrorResponses
{
	protected function handleResponse() { }

	protected function throwException( BadResponseException $exception )
	{
		switch ( $exception->getResponse()->getStatusCode() ) {
			case 401:
				throw new UnauthorizedResponseException( $exception->getResponse()->getBody()->getContents() );
			case 422:
				throw new ValidationErrorResponseException( $exception->getResponse()->getBody()->getContents() );
			case 429:
				throw new ThrottledResponseException( $exception->getResponse()->getBody()->getContents() );
			case $exception->getResponse()->getStatusCode() >= 500:
				throw new ServerErrorException( $exception->getMessage(), $exception->getResponse()->getStatusCode(), $exception );
			default:
				throw $exception;
		}
	}
}