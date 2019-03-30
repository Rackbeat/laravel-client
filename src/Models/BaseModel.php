<?php

namespace Rackbeat\Models;

use Rackbeat\Exceptions\Models\DataFormatInvalidException;
use Rackbeat\Exceptions\Models\ImmutableOriginalDataException;
use Rackbeat\Models\Utilities\AttributeCaster;

class BaseModel
{
	/** @var array */
	protected $data = [];

	/** @var array */
	protected $original = [];

	/** @var array */
	protected $casts = [];

	/** @var array */
	protected static $defaultCasts = [];

	/**
	 * BaseModel constructor.
	 *
	 * @param array|object|string $data
	 *
	 * @throws DataFormatInvalidException
	 */
	public function __construct( $data = [] ) {
		$this->setData( $data );
	}

	public function __get( $name ) {
		return $this->data[ $name ] ?? null;
	}

	public function __set( $name, $value ) {
		if ( \in_array( $name, [ 'data' ] ) ) {
			$this->setData( $value );

			return;
		}

		if ( \in_array( $name, [ 'original' ] ) ) {
			throw new ImmutableOriginalDataException( 'Original data for ' . \get_class( $this ) . ' cannot be directly modified.' );
		}

		$this->setAttribute( $name, $value );
	}

	public function __isset( $name ) {
		return isset( $this->data[ $name ] );
	}

	protected function setAttribute( $key, $value ) {
		// todo allow override like Laravel! (setXXAttribute)

		$value = AttributeCaster::castValueForKey( $key, $value, array_merge( static::$defaultCasts, $this->casts ) );

		$this->data[ $key ]     = $value;
		$this->original[ $key ] = $value;
	}

	public function toArray() {
		return $this->data;
	}

	public function toJson() {
		return json_encode( $this->data );
	}

	public function toObject() {
		return json_decode( json_encode( $this->data ) );
	}

	public function getData() {
		return $this->data;
	}

	public function getOriginal() {
		return $this->original;
	}

	public function getDirty() {
		return array_filter( $this->data, function ( $value, $key ) {
			return $this->original[ $key ] !== $value;
		}, ARRAY_FILTER_USE_BOTH );
	}

	/**
	 * Undo dirty changes and revert to original values.
	 */
	public function cleanup() {
		$this->data = $this->original;
	}

	/**
	 * @param array $data
	 *
	 * @throws DataFormatInvalidException
	 */
	protected function setData( $data = [] ) {
		if ( ! \is_object( $data ) && ! \is_array( $data ) && ! $data = json_decode( $data ) ) {
			throw new DataFormatInvalidException( 'Data must be either a object, array or a JSON-formatted string.' );
		}

		foreach ( $data as $key => $value ) {
			$this->setAttribute( $key, $value );
		}
	}

	protected function setCasts( $casts = [] ) {
		$this->casts = $casts;
	}

	public static function mock( $data = [], $casts = [] ) {
		$model = new static( [] );

		$model->setCasts( $casts );
		$model->setData( $data );

		return $model;
	}
}