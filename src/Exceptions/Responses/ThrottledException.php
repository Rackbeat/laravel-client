<?php

namespace RackbeatSDK\Exceptions\Responses;

class ThrottledException extends BadResponseException
{
	protected $code = 429;
}