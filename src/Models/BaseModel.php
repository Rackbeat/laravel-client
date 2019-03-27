<?php

namespace Rackbeat\Models;

class BaseModel
{
	/** @var array */
	protected $data     = [];
	protected $original = [];

	public function __construct( $data = [] ) {
		$this->data     = $data;
		$this->original = $data;
	}

	public function __get( $name ) {
		return $this->data[ $name ] ?? null;
	}

	public function __set( $name, $value ) {
		if ( \in_array( $name, [ 'data', 'original' ] ) ) {
			$this[ $name ] = $value;

			return;
		}

		$this->data[ $name ] = $value;
	}

	public function __isset( $name ) {
		return isset( $this->data[ $name ] );
	}

	public function toArray() { }

	public function toJson() { }
}