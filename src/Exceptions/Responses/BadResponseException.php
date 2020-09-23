<?php

namespace RackbeatSDK\Exceptions\Responses;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use RackbeatSDK\Http\Traits\HandlesResponseData;
use Throwable;

class BadResponseException extends \Exception
{
	use HandlesResponseData;

	public $body;

	public function __construct( \GuzzleHttp\Exception\BadResponseException $guzzleException, $code = 0, Throwable $previous = null )
	{
		$content = $guzzleException->getResponse()->getBody()->getContents();

		parent::__construct( $guzzleException->getRequest()->getMethod() . ' ' . $guzzleException->getRequest()->getUri() . ' resulted in ' . $guzzleException->getResponse()->getStatusCode() . ' ' . $content , $code, $previous );

		$this->body = $this->parseResponse( $guzzleException->getResponse(), $content );
	}

	public function getHttpCode(): int
	{
		return (int) $this->getCode();
	}

	public function getResponseBody()
	{
		return $this->body;
	}
}
