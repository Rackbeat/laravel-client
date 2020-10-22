<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Customer;

class CustomerResource extends CrudResource
{
	protected const MODEL         = Customer::class;
	protected const RESOURCE_KEY  = 'customer';
	protected const ENDPOINT_BASE = 'customers';
}