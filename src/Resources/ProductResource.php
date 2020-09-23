<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Lot;

class ProductResource extends CrudResource
{
	protected const MODEL         = Lot::class;
	protected const RESOURCE_KEY  = 'product';
	protected const ENDPOINT_BASE = '/products';
}