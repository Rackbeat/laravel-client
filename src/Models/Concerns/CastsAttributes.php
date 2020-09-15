<?php

namespace RackbeatSDK\Models\Concerns;

use Carbon\Carbon;

/**
 * Lots of the code has been carelessly stolen from
 * https://github.com/laravel/framework/blob/5.8/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php
 *
 * Thank you for the impressive work!
 */
trait CastsAttributes
{
	/**
	 * List of casts
	 *
	 * @var array
	 */
	protected $casts = [];

	/** @var array */
	protected static $defaultCasts = [
		'id'           => 'integer',
		'self'         => 'string',
		'created_at'   => 'datetime',
		'updated_at'   => 'datetime',
		'deleted_at'   => 'datetime',
		'booked_at'    => 'datetime',
		'shipped_at'   => 'datetime',
		'finished_at'  => 'datetime',
		'received_at'  => 'datetime',
		'invoiced_at'  => 'datetime',
		'cancelled_at' => 'datetime',
	];

	protected function getDateTimeFormat() {
		$format = 'Y-m-d\TH:i:sP';

		// https://bugs.php.net/bug.php?id=75577
		// consider removing this as we don't actually use .v anyway.
		if ( version_compare( PHP_VERSION, '7.3.0-dev', '<' ) ) {
			$format = str_replace( '.v', '.u', $format );
		}

		return $format;
	}

	protected function getDateFormat() {
		return 'Y-m-d';
	}

	protected function castFromValue( $key, $value ) {
		if ( \is_null( $value ) ) {
			return $value;
		}

		if ( ! array_key_exists( $key, $this->casts ) ) {
			return $value;
		}

		switch ( \strtolower( $this->casts[ $key ] ) ) {
			case 'str':
			case 'string':
				return (string) $value;
			case 'int':
			case 'integer':
				return (int) $value;
			case 'float':
			case 'double':
				return $this->fromFloat( $value );
			case 'bool':
			case 'boolean':
				return (bool) filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			case 'date':
				return $this->fromDate( $value );
			case 'datetime':
				return $this->fromDateTime( $value );
			default:
				return $value;
		}
	}

	protected function castToValue( $key, $value ) {
		if ( \is_null( $value ) ) {
			return $value;
		}

		if ( ! array_key_exists( $key, $this->casts ) ) {
			return $value;
		}

		switch ( \strtolower( $this->casts[ $key ] ) ) {
			case 'str':
			case 'string':
				return (string) $value;
			case 'int':
			case 'integer':
				return (int) $value;
			case 'float':
			case 'double':
				return $this->fromFloat( $value );
			case 'bool':
			case 'boolean':
				return (bool) filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			case 'date':
				return $this->asDate( $value );
			case 'datetime':
				return $this->asDateTime( $value );
			case 'array':
				return (array) ( \is_string( $value ) ? json_decode( $value, true ) : $value );
			case 'object':
				return (object) ( \is_string( $value ) ? json_decode( $value, false ) : $value );
			case 'json':
				return json_encode( $value );
			default:
				return $value;
		}
	}

	/**
	 * Decode the given float.
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	protected function fromFloat( $value ) {
		switch ( (string) $value ) {
			case 'Infinity':
				return INF;
			case '-Infinity':
				return -INF;
			case 'NaN':
				return NAN;
			default:
				return (float) $value;
		}
	}

	protected function fromDateTime( $value ) {
		return empty( $value ) ? $value : $this->asDateTime( $value )->format(
			$this->getDateTimeFormat()
		);
	}

	public function fromDate( $value ) {
		return empty( $value ) ? $value : $this->asDateTime( $value )->format(
			$this->getDateFormat()
		);
	}

	/**
	 * Return a timestamp as DateTime object.
	 *
	 * @param mixed $value
	 *
	 * @return Carbon
	 */
	protected function asDateTime( $value ) {
		// This prevents us having to re-instantiate a Carbon instance when we know
		// it already is one, which wouldn't be fulfilled by the DateTime check.
		if ( $value instanceof \Illuminate\Support\Carbon || $value instanceof \Carbon\CarbonInterface ) {
			return Carbon::instance( $value );
		}

		// If the value is already a DateTime instance, we will just skip the rest of
		// these checks since they will be a waste of time, and hinder performance
		// when checking the field. We will just return the DateTime right away.
		if ( $value instanceof \DateTimeInterface ) {
			return Carbon::parse(
				$value->format( 'Y-m-d H:i:s.u' ), $value->getTimezone()
			);
		}

		// If this value is an integer, we will assume it is a UNIX timestamp's value
		// and format a Carbon object from this timestamp. This allows flexibility
		// when defining your date fields as they might be UNIX timestamps here.
		if ( is_numeric( $value ) ) {
			return Carbon::createFromTimestamp( $value );
		}

		// If the value is in simply year, month, day format, we will instantiate the
		// Carbon instances from that format. Again, this provides for simple date
		// fields on the database, while still supporting Carbonized conversion.
		if ( $this->isStandardDateFormat( $value ) ) {
			return Carbon::instance( Carbon::createFromFormat( 'Y-m-d', $value )->startOfDay() );
		}

		$format = $this->getDateTimeFormat();

		// Finally, we will just assume this date is in the format used by default on
		// the database connection and use that format to create the Carbon object
		// that is returned back out to the developers after we convert it here.
		return Carbon::createFromFormat( $format, $value );
	}

	/**
	 * Return a timestamp as DateTime object with time set to 00:00:00.
	 *
	 * @param mixed $value
	 *
	 * @return Carbon
	 */
	public function asDate( $value ) {
		return $this->asDateTime( $value )->startOfDay();
	}

	/**
	 * Determine if the given value is a standard date format.
	 *
	 * @param string $value
	 *
	 * @return bool
	 */
	protected function isStandardDateFormat( $value ) {
		return preg_match( '/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value );
	}

	protected function castArrayOfAttributes( $attributes = [] ) {
		return array_combine(
			$arrayKeys = array_keys( $attributes ),

			array_map( function ( $key ) {
				return $this->castToValue( $key, $this->data[ $key ] ?? null );
			}, $arrayKeys )
		);
	}

	protected function castBackArrayOfAttributes( $attributes = [] ) {
		return array_combine(
			$arrayKeys = array_keys( $attributes ),

			array_map( function ( $key ) {
				return $this->castFromValue( $key, $this->data[ $key ] ?? null );
			}, $arrayKeys )
		);
	}
}