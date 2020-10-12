<?php

namespace RackbeatSDK\Http;

class QueryString
{
	private array $parts = [];

	public function add( $key, $value ): void
	{
		$this->parts[ $key ] = $value;
	}

	public function addNested( $key, $index, $value ): void
	{
		$this->parts[ $key ][ $index ] = $value;
	}

	public function set( $array ): void
	{
		$this->parts = $array;
	}

	public function build( $separator = '&', $equals = '=' ): string
	{
		$queryString = [];

		$queryString = $this->untanglePart( $this->parts, $queryString, null, $equals );

		return implode( $separator, $queryString );
	}

	protected function untanglePart( $parts, $queryString, $parentKey = null, $equals = '=' )
	{
		foreach ( $parts as $key => $part ) {
			if ( is_array( $part ) ) {
				foreach ( $this->untanglePart( $part, $queryString, $key, $equals ) as $subPart ) {
					$queryString[] = $subPart;
				}
			} else {
				$queryString[] = ( $parentKey ? urlencode( $parentKey ) . '[' . urlencode( $key ) . ']' : $key ) . $equals . urlencode( $part );
			}
		}

		return $queryString;
	}

	public static function make( $array = [] )
	{
		$queryString = new self;
		$queryString->set( $array );

		return $queryString;
	}

	public function __toString()
	{
		return $this->build();
	}
}