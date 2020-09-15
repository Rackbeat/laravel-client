<?php

namespace RackbeatSDK\Exceptions\Responses;

class ValidationErrorException extends ResponseException
{
	protected $code = 422;
}