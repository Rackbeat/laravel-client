<?php

namespace RackbeatSDK\Exceptions\Responses;

class UnauthorizedResponseException extends \Exception
{
	protected $code = 401;
}