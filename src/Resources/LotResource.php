<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Lot;
use RackbeatSDK\Resources\Filters\ItemFilters;

class LotResource extends CrudResource
{
	use ItemFilters;

	protected const MODEL         = Lot::class;
	protected const RESOURCE_KEY  = 'lot';
	protected const ENDPOINT_BASE = 'lots';
}