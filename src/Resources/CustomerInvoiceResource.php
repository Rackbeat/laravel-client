<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\CustomerInvoice;

class CustomerInvoiceResource extends CrudResource
{
	protected const MODEL         = CustomerInvoice::class;
	protected const RESOURCE_KEY  = 'customer_invoice';
	protected const ENDPOINT_BASE = 'customer_invoices';
}