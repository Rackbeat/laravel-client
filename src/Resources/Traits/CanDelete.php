<?php

namespace Rackbeat\Resources\Traits;

use Rackbeat\Models\BaseModel;

trait CanDelete
{
	/**
	 * @param BaseModel|integer|string $id
	 */
	public function delete( $id ) { }
}