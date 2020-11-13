<?php

namespace RackbeatSDK\Resources\Traits;

use RackbeatSDK\Http\Responses\IndexResponse;
use RackbeatSDK\Http\Responses\PaginatedIndexResponse;
use RackbeatSDK\Models\Model;

/**
 * @method PaginatedIndexResponse|IndexResponse get( $page = 1, $perPage = 20, array $query = [] )
 * @method IndexResponse all( array $query = [] )
 * @method Model first( array $query = [] )
 */
trait CanIndex
{
}