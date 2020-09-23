<?php

namespace RackbeatSDK\Resources;

use Illuminate\Support\Str;
use RackbeatSDK\API;
use RackbeatSDK\Http\Responses\IndexResponse;
use RackbeatSDK\Http\Responses\PaginatedIndexResponse;

class BaseResource
{
	/** @var string */
	protected const ENDPOINT_BASE = '/';

	/** @var string */
	protected const RESOURCE_KEY = 'item';

	/** @var null|string */
	protected const MODEL = null;

	/** @var null|string */
	protected const RESOURCE_KEY_PLURAL = null;

	public function __construct()
	{
	}

	public function __call( $name, $arguments )
	{
		if ( method_exists( $this, $name ) ) {
			return static::$name( $arguments );
		}

		throw new \BadMethodCallException( sprintf( 'Method "%s" does not exist in class %s', $name, static::class ) );
	}

	public static function getIndexUrl(): string
	{
		return trim(static::ENDPOINT_BASE, '/');
	}

	protected static function index( $query = [] )
	{
		$responseData = API::http()->get( static::getIndexUrl(), $query );

		if ( method_exists( static::class, 'formatIndexResponse' ) ) {
			return static::formatIndexResponse( $responseData );
		}

		$items = $responseData[ static::getPluralisedKey() ];

		if ( $model = static::MODEL ) {
			$items = array_map( function ( $item ) use ( $model ) { return new $model( $item ); }, $items );
		}

		if ( isset( $responseData['pages'] ) ) {
			return new PaginatedIndexResponse(
				$items,
				$responseData['pages'],
				$responseData['page'],
				$responseData['total'],
			);
		}

		return new IndexResponse( $items );
	}

	protected static function delete( $key ) { }

	protected static function find( $key ) { }

	protected static function update( $model ) { }

	protected static function create( $data = [] ) { }

	/**
	 * Get the resource key, singular.
	 *
	 * @return string
	 */
	protected function getSingularKey(): string
	{
		return static::RESOURCE_KEY;
	}

	/**
	 * Get the resource key, pluralised.
	 *
	 * Uses Illuminate Str::plural (as does Rackbeat API) but can be overridden as necessary.
	 *
	 * To override the default, set your RESOURCE_KEY_PLURAL to the plural version.
	 *
	 * Example:
	 *
	 * RESOURCE_KEY         = person
	 * RESOURCE_KEY_PLURAL  = people
	 *
	 * @return string
	 */
	protected static function getPluralisedKey(): string
	{
		return static::RESOURCE_KEY_PLURAL ?? Str::plural( static::RESOURCE_KEY );
	}
}