<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Field;

class FieldResource extends CrudResource
{
	protected const MODEL         = Field::class;
	protected const RESOURCE_KEY  = 'field';
	protected const ENDPOINT_BASE = 'fields';
}