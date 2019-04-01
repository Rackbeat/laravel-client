<?php

namespace Rackbeat\Models\Utilities;

class AttributeCaster
{
	public static function castValueForKey( $key, $value, $casts ) {
		if ( ! array_key_exists( $key, $casts ) ) {
			return $value;
		}

		switch ( \strtolower( $casts[ $key ] ) ) {
			case 'str':
			case 'string':
				return (string) $value;
			case 'int':
			case 'integer':
				return (int) $value;
			case 'float':
			case 'double':
				return (double) $value;
			case 'bool':
			case 'boolean':
				return (bool) filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			case 'datetime':
				return new \DateTime( $value );
			case 'array':
				return (array) ( \is_string( $value ) ? json_decode( $value ) : $value );
			case 'object':
				return (object) ( \is_string( $value ) ? json_decode( $value ) : $value );
			case 'json':
				return json_encode( $value );
			default:
				return $value;
		}
	}
}