<?php

namespace RackbeatSDK\Exceptions\Responses;

class ThrottledException extends RackbeatResponseException
{
	protected $code = 429;
}