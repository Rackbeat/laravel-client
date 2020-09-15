<?php

namespace RackbeatSDK\Exceptions\Responses;

class ResponseException extends \Exception
{
	public function getHttpCode(): int
	{
		return (int) $this->getCode();
	}

	public function getBody(): array
	{
		return json_decode( $this->getMessage(), true, 512, JSON_THROW_ON_ERROR );
	}
}