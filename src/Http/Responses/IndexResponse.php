<?php

namespace RackbeatSDK\Http\Responses;

class IndexResponse implements \ArrayAccess, \Iterator, \Countable
{
	public array $items;

	private int $position = 0;

	public function __construct( array $items )
	{
		$this->items = $items;
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
		$this->position++;
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

	/**
	 * @inheritDoc
	 */
	public function count()
	{
		return count( $this->items );
	}

	public function toArray(): array
	{
		return $this->items;
	}

	public function filter( callable $filter ): IndexResponse
	{
		$items = array_filter( $this->items, $filter );

		return new IndexResponse( $items );
	}

	public function map( callable $map ): IndexResponse
	{
		$items = array_map( $map, $this->items );

		return new IndexResponse( $items );
	}
}