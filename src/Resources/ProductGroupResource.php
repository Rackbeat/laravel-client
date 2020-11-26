<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\ProductGroup;

class ProductGroupResource extends CrudResource
{
	protected const MODEL         = ProductGroup::class;
	protected const RESOURCE_KEY  = 'product_group';
	protected const ENDPOINT_BASE = 'product_groups';
}