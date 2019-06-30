<?php

namespace Rackbeat\Http\Responses;

class PaginatedResponse extends Response implements \ArrayAccess
{
	/** @var integer */
	public $pages;

	/** @var integer */
	public $total;

	/** @var integer */
	public $currentPage;

	/** @var array */
	public $items;

	public function offsetSet( $offset, $value ): void {
		if ( $offset === null ) {
			$this->items[] = $value;
		} else {
			$this->items[ $offset ] = $value;
		}
	}

	public function offsetExists( $offset ): bool {
		return isset( $this->items[ $offset ] );
	}

	public function offsetUnset( $offset ): void {
		unset( $this->items[ $offset ] );
	}

	public function offsetGet( $offset ) {
		return $this->items[ $offset ] ?? null;
	}
}