<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Product;

class ProductResource extends CrudResource
{
	protected const MODEL         = Product::class;
	protected const RESOURCE_KEY  = 'product';
	protected const ENDPOINT_BASE = 'products';
}