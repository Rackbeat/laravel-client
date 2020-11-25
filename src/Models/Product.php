<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\ProductResource;

class Product extends Item
{
	protected static string $RESOURCE = ProductResource::class;
}