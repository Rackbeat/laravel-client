<?php

namespace Rackbeat\Resources;

use Rackbeat\Resources\Traits\CanCreate;
use Rackbeat\Resources\Traits\CanDelete;
use Rackbeat\Resources\Traits\CanFind;
use Rackbeat\Resources\Traits\CanIndex;
use Rackbeat\Resources\Traits\CanUpdate;

class CrudResource extends BaseResource
{
	use CanIndex, CanFind, CanCreate, CanUpdate, CanDelete;
}