<?php

namespace RackbeatSDK\Exceptions\Responses;

class UnauthorizedException extends RackbeatResponseException
{
	protected $code = 401;
}