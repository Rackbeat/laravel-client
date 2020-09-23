<?php

namespace RackbeatSDK\Http\Responses;

use Illuminate\Pagination\Paginator;

class PaginatedIndexResponse extends IndexResponse implements \ArrayAccess
{
	public int $pages;

	public int $total;

	public int $currentPage;

	public int $perPage;

	public function __construct( array $items, int $pages, int $currentPage, int $perPage, int $total )
	{
		parent::__construct( $items );

		$this->pages       = $pages;
		$this->currentPage = $currentPage;
		$this->perPage     = $perPage;
		$this->total       = $total;
	}

	public function getPaginator( $options = [] ): Paginator
	{
		return new Paginator( $this->total, $this->perPage, $this->currentPage, $options );
	}

	public function offsetSet( $offset, $value ): void
	{
		if ( $offset === null ) {
			$this->items[] = $value;
		} else {
			$this->items[ $offset ] = $value;
		}
	}

	public function offsetExists( $offset ): bool
	{
		return isset( $this->items[ $offset ] );
	}

	public function offsetUnset( $offset ): void
	{
		unset( $this->items[ $offset ] );
	}

	public function offsetGet( $offset )
	{
		return $this->items[ $offset ] ?? null;
	}
}