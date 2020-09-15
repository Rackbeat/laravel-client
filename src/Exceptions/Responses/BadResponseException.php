<?php

namespace RackbeatSDK\Exceptions\Responses;

use GuzzleHttp\Psr7\Response;
use RackbeatSDK\Http\Traits\HandlesErrorResponses;
use RackbeatSDK\Http\Traits\HandlesResponseData;
use Throwable;

class BadResponseException extends \Exception
{
	use HandlesResponseData;

	public function __construct( Response $response, $code = 0, Throwable $previous = null ) { parent::__construct( $this->parseResponse($response), $code, $previous ); }

	public function getHttpCode(): int
	{
		return (int) $this->getCode();
	}
}