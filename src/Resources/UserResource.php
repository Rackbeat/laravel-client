<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\User;

class UserResource extends CrudResource
{
	protected const MODEL         = User::class;
	protected const RESOURCE_KEY  = 'user';
	protected const ENDPOINT_BASE = 'users';
}