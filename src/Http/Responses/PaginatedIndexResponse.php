<?php

namespace RackbeatSDK\Http\Responses;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatedIndexResponse extends IndexResponse
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

	public function filter( callable $filter ): PaginatedIndexResponse
	{
		$items = array_filter( $this->items, $filter );

		return new PaginatedIndexResponse( $items );
	}
}