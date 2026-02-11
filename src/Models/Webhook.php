<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\WebhookResource;

/**
 * @property int            $id
 * @property string         $event
 * @property string         $url
 * @property bool           $is_active
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read string    $self
 */
class Webhook extends Model
{
	protected static string $RESOURCE = WebhookResource::class;

	protected array $casts = [
		'is_active' => 'boolean',
	];
}
