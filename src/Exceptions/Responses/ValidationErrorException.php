<?php

namespace RackbeatSDK\Exceptions\Responses;

class ValidationErrorException extends BadResponseException
{
	protected $code = 422;
}