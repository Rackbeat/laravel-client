<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Lot;

class LotResource extends CrudResource
{
	protected const MODEL         = Lot::class;
	protected const RESOURCE_KEY  = 'lot';
	protected const ENDPOINT_BASE = '/lots';
}