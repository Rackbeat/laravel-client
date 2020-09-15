<?php

namespace RackbeatSDK\Http\Responses;

class PaginatedIndexResponse extends IndexResponse implements \ArrayAccess
{
	public int $pages;

	public int $total;

	public int $currentPage;

	public function __construct( array $items, int $pages, int $currentPage, int $total )
	{
		parent::__construct($items);

		$this->pages       = $pages;
		$this->currentPage = $currentPage;
		$this->total       = $total;
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