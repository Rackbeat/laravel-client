<?php

namespace Rackbeat\RackbeatSDK\Resources\Traits;

use Rackbeat\Models\Model;

trait CanDelete
{
	/**
	 * @param Model|integer|string $id
	 */
	public function delete( $id ) { }
}