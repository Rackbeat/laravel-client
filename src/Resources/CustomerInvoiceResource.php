<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\API;
use RackbeatSDK\Http\Responses\PdfResponse;
use RackbeatSDK\Models\CustomerInvoice;

class CustomerInvoiceResource extends CrudResource
{
	protected const MODEL         = CustomerInvoice::class;
	protected const RESOURCE_KEY  = 'customer_invoice';
	protected const ENDPOINT_BASE = 'customer-invoices';

	public function getPdf( int $invoiceNumber ): PdfResponse
	{
		return API::http()->get( self::ENDPOINT_BASE . '/' . $invoiceNumber . '.pdf', [] );
	}
}