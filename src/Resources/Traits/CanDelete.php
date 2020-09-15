<?php

namespace RackbeatSDK\Resources\Traits;

use RackbeatSDK\Models\Model;

trait CanDelete
{
	/**
	 * @param Model|integer|string $id
	 */
	public function delete( $id ) { }
}