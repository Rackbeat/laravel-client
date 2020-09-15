<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Resources\Traits\CanCreate;
use RackbeatSDK\Resources\Traits\CanDelete;
use RackbeatSDK\Resources\Traits\CanFind;
use RackbeatSDK\Resources\Traits\CanIndex;
use RackbeatSDK\Resources\Traits\CanUpdate;

class CrudResource extends BaseResource
{
	use CanIndex, CanFind, CanCreate, CanUpdate, CanDelete;
}