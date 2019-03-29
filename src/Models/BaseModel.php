<?php

namespace Rackbeat\Models;

class BaseModel
{
	/** @var array */
	protected $data     = [];
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
		return $this->data[ $name ] ?? null;
	}

	public function __set( $name, $value ) {
		if ( \in_array( $name, [ 'data', 'original' ] ) ) {
			$this->{$name} = $value;

			return;
		}

		$this->data[ $name ] = $value;
	}

	public function __isset( $name ) {
		return isset( $this->data[ $name ] );
	}

	public function toArray() { }

	public function toJson() { }

	public function toObject() { }

	public function getData() {
		return $this->data;
	}

	public function getOriginal() {
		return $this->original;
	}

	public function getDirty() {
		return array_filter( $this->original, function ( $value, $key ) {
			return $this->data[ $key ] !== $value;
		}, ARRAY_FILTER_USE_BOTH );
	}

	public function refresh() {
		// todo implement method to GET fresh data
	}

	/**
	 * @param array $data
	 */
	protected function setData( $data = [] ) {
		if ( \is_object( $data ) ) {
			// todo find a faster way to do this
			$data = json_decode( json_encode( $data ), true );
		}

		$this->data     = $data;
		$this->original = $data;
	}
}