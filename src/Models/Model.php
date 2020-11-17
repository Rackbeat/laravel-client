<?php

namespace RackbeatSDK\Models;

use Illuminate\Support\Str;
use RackbeatSDK\Exceptions\Models\DataFormatInvalidException;
use RackbeatSDK\Exceptions\Models\ImmutableOriginalDataException;
use RackbeatSDK\Models\Concerns\CastsAttributes;

class Model
{
	use CastsAttributes;

	/** @var array */
	protected array $data = [];

	/** @var array */
	protected array $original = [];

	/** @var string */
	protected string $primaryKey = 'id';

	protected static string $RESOURCE;

	/**
	 * integer og string
	 *
	 * For example, products and lots use a string key
	 * whereas invoices use an integer.
	 *
	 * @var string
	 */
	protected string $keyType = 'integer';

	/**
	 * Model constructor.
	 *
	 * @param array|object|string $data
	 *
	 * @throws DataFormatInvalidException
	 */
	public function __construct( $data = [] )
	{
		$this->setData( $data );
	}

	public static function mock( $data = [], $casts = [] )
	{
		$model = new static( [] );

		$model->setCasts( $casts );
		$model->setData( $data );

		return $model;
	}

	protected function setCasts( $casts = [] )
	{
		$this->casts = $casts;
	}

	public function __toString(): string
	{
		return $this->toJson();
	}

	public function __get( $name )
	{
		if ( method_exists( $this, $method = 'get' . Str::ucfirst( Str::camel( $name ) ) . 'Attribute' ) ) {
			return $this->{$method}( $this->data[ $name ] ?? null );
		}

		return $this->castToValue( $name, $this->data[ $name ] ?? null );
	}

	public function __set( $name, $value )
	{
		if ( \in_array( $name, [ 'data' ] ) ) {
			$this->setData( $value );

			return;
		}

		if ( \in_array( $name, [ 'original' ] ) ) {
			throw new ImmutableOriginalDataException( 'Original data for ' . \get_class( $this ) . ' cannot be directly modified.' );
		}

		$this->setAttribute( $name, $value );
	}

	protected function setAttribute( $key, $value, $overrideOriginal = false ): void
	{
		if ( method_exists( $this, $method = 'set' . Str::ucfirst( Str::camel( $key ) ) . 'Attribute' ) ) {
			$value = $this->{$method}( $value );
		} else {
			$value = $this->castFromValue( $key, $value );
		}

		$this->data[ $key ] = $value;

		if ( $overrideOriginal ) {
			$this->original[ $key ] = $value;
		}
	}

	public function __isset( $name )
	{
		return isset( $this->data[ $name ] );
	}

	public function toArray(): array
	{
		return $this->castArrayOfAttributes( $this->data );
	}

	public function toJson(): string
	{
		return json_encode( $this->castBackArrayOfAttributes( $this->data ), JSON_THROW_ON_ERROR );
	}

	public function toObject(): \stdClass
	{
		return json_decode( $this->toJson(), false, 512, JSON_THROW_ON_ERROR );
	}

	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @param array $data
	 *
	 * @throws DataFormatInvalidException
	 */
	protected function setData( $data = [] ): void
	{
		if ( ! \is_object( $data ) && ! \is_array( $data ) && ! $data = json_decode( $data, true, 512 ) ) {
			throw new DataFormatInvalidException( 'Data must be either a object, array or a JSON-formatted string.' );
		}

		foreach ( $data as $key => $value ) {
			$this->setAttribute( $key, $value, true );
		}
	}

	/**
	 * @param Model $model
	 */
	protected function overrideDataFromModel( Model $model ): void
	{
		$this->original = $model->original;
		$this->data     = $model->data;
	}

	public function getOriginal(): array
	{
		// consider casting?
		return $this->original;
	}

	// todo move to a trait as not everything can be deleted?
	public function delete()
	{
		return ( new static::$RESOURCE )->delete( $this->getPrimaryKey() );
	}

	public function getPrimaryKey()
	{
		return $this->{$this->primaryKey};
	}

	public function getDirty(): array
	{
		// consider casting?
		return array_filter( $this->data, function ( $value, $key ) {
			return $this->original[ $key ] !== $value;
		}, ARRAY_FILTER_USE_BOTH );
	}

	/**
	 * Undo dirty changes and revert to original values.
	 */
	public function cleanup(): void
	{
		$this->data = $this->original;
	}
}