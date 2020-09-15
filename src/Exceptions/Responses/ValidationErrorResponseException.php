<?php

namespace RackbeatSDK\Exceptions\Responses;

class ValidationErrorResponseException extends RackbeatResponseException
{
	protected $code = 422;
}