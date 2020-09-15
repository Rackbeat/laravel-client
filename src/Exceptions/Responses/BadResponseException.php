<?php

namespace RackbeatSDK\Exceptions\Responses;

use GuzzleHttp\Psr7\Response;
use RackbeatSDK\Http\Traits\HandlesResponseData;
use Throwable;

class BadResponseException extends \Exception
{
	use HandlesResponseData;

	public $body;

	public function __construct( Response $response, $code = 0, Throwable $previous = null )
	{
		parent::__construct( $response->getBody()->getContents(), $code, $previous );

		$this->body = $this->parseResponse( $response );
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