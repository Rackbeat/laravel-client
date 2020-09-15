<?php

namespace RackbeatSDK\Exceptions\Responses;

class ThrottledException extends ResponseException
{
	protected $code = 429;
}