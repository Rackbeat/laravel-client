<?php

namespace RackbeatSDK\Http\Responses;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatedIndexResponse extends IndexResponse implements \ArrayAccess, \Iterator
{
	public int $pages;

	public int $total;

	public int $currentPage;

	public int $perPage;

	private int $position = 0;

	public function __construct( array $items, int $pages, int $currentPage, int $perPage, int $total )
	{
		parent::__construct( $items );

		$this->pages       = $pages;
		$this->currentPage = $currentPage;
		$this->perPage     = $perPage;
		$this->total       = $total;
	}

	public function getPaginator( $options = [] ): LengthAwarePaginator
	{
		return Container::getInstance()->makeWith( LengthAwarePaginator::class, [
			'items'       => $this->items,
			'total'       => $this->total,
			'perPage'     => $this->perPage,
			'currentPage' => $this->currentPage,
			'options'     => $options
		] );
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

	/**
	 * @inheritDoc
	 */
	public function current()
	{
		return $this->items[ $this->position ];
	}

	/**
	 * @inheritDoc
	 */
	public function next()
	{
		if ( $this->position < \count( $this->items ) - 1 ) {
			$this->position++;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function key()
	{
		return $this->position;
	}

	/**
	 * @inheritDoc
	 */
	public function valid()
	{
		return isset( $this->items[ $this->position ] );
	}

	/**
	 * @inheritDoc
	 */
	public function rewind()
	{
		$this->position = 0;
	}
}