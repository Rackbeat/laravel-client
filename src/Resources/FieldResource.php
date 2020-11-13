<?php

namespace RackbeatSDK\Resources;

use RackbeatSDK\Models\Field;

class FieldResource extends CrudResource
{
	protected const MODEL         = Field::class;
	protected const RESOURCE_KEY  = 'field';
	protected const ENDPOINT_BASE = 'fields';

	public function forCustomers(): FieldResource
	{
		$this->where( 'available_for', 'customer' );

		return $this;
	}

	public function forSuppliers(): FieldResource
	{
		$this->where( 'available_for', 'supplier' );

		return $this;
	}

	public function forItems(): FieldResource
	{
		$this->where( 'available_for', 'item' );

		return $this;
	}

	public function dropdowns(): FieldResource
	{
		$this->where( 'type', 'dropdown' );

		return $this;
	}
}