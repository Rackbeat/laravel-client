<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\CustomerInvoice;
use RackbeatSDK\Models\Field;
use RackbeatSDK\Models\Order;

class CustomerInvoiceResource extends CrudResource
{
	protected const MODEL         = CustomerInvoice::class;
	protected const RESOURCE_KEY  = 'customer_invoice';
	protected const ENDPOINT_BASE = 'customer_invoices';
}