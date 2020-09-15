<?php

namespace RackbeatSDK\Exceptions\Responses;

class UnauthorizedResponseException extends RackbeatResponseException
{
	protected $code = 401;
}