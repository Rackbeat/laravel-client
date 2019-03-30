<?php

namespace Rackbeat\Models;

class BaseModel
{
	/** @var object */
	protected $data = [];

	/** @var object */
	protected $original = [];

	/**
	 * BaseModel constructor.
	 *
	 * @param array|object $data
	 */
	public function __construct( $data = [] ) {
		$this->setData( $data );
	}

	public function __get( $name ) {
		return $this->data->{$name} ?? null;
	}

	public function __set( $name, $value ) {
		if ( \in_array( $name, [ 'data' ] ) ) {
			$this->setData( $value );

			return;
		}

		if ( \in_array( $name, [ 'original' ] ) ) {
			throw new \Exception( 'cannot modify original data directly.' ); // todo find alternative!
		}

		$this->data->{$name} = $value;
	}

	public function __isset( $name ) {
		return isset( $this->data->{$name} );
	}

	public function toArray() {
		return json_decode( json_encode( $this->data ), true );
	}

	public function toJson() {
		return json_encode( $this->data );
	}

	public function toObject() {
		return $this->data;
	}

	public function getData() {
		return $this->data;
	}

	public function getOriginal() {
		return $this->original;
	}

	public function getDirty() {
		return array_filter( (array) $this->data, function ( $value, $key ) {
			return $this->original->{$key} !== $value;
		}, ARRAY_FILTER_USE_BOTH );
	}

	public function refresh() {
		// todo implement method to GET fresh data
	}

	/**
	 * @param array $data
	 */
	protected function setData( $data = [] ) {
		if ( \is_array( $data ) ) {
			// todo find a faster way to do this
			$data = json_decode( json_encode( $data ) );
		}

		$this->data     = $data;
		$this->original = clone $data;
	}
}