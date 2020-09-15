<?php

namespace RackbeatSDK\Exceptions\Responses;

class ValidationErrorException extends RackbeatResponseException
{
	protected $code = 422;
}