<?php

namespace RackbeatSDK\Exceptions\Responses;

class ThrottledResponseException extends RackbeatResponseException
{
	protected $code = 429;
}