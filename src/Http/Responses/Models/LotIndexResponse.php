<?php

namespace RackbeatSDK\Http\Responses\Models;

use RackbeatSDK\Http\Responses\PaginatedIndexResponse;
use RackbeatSDK\Models\Lot;

class LotIndexResponse extends PaginatedIndexResponse
{
	/** @var Lot[] */
	public array $items;
}