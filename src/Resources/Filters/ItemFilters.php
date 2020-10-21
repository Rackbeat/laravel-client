<?php

namespace RackbeatSDK\Resources\Filters;

trait ItemFilters
{
	public function sellable( $isSellable = true )
	{
		$this->where( 'is_sellable', $isSellable );

		return $this;
	}

	public function notSellable()
	{
		return $this->sellable( false );
	}
}