<?php

namespace RackbeatSDK\Http\Responses;

class IndexResponse
{
	public array $items;

	public function __construct( array $items )
	{
		$this->items = $items;
	}
}