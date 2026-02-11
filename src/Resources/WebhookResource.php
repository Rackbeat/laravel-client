<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Webhook;

class WebhookResource extends CrudResource
{
	protected const MODEL         = Webhook::class;
	protected const RESOURCE_KEY  = 'webhook';
	protected const ENDPOINT_BASE = 'webhooks';
}
