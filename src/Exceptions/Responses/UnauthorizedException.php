<?php

namespace RackbeatSDK\Exceptions\Responses;

class UnauthorizedException extends BadResponseException
{
	protected $code = 401;
}