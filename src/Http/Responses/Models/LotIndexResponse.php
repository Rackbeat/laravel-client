<?php

namespace RackbeatSDK\Http\Responses\Models;
// todo use this
use RackbeatSDK\Http\Responses\PaginatedIndexResponse;
use RackbeatSDK\Models\Lot;

class LotIndexResponse extends PaginatedIndexResponse
{
	/** @var Lot[] */
	public array $items;
}