<?php

namespace RackbeatSDK\Resources;

use Illuminate\Support\Str;
use RackbeatSDK\API;
use RackbeatSDK\Http\QueryString;
use RackbeatSDK\Http\Responses\IndexResponse;
use RackbeatSDK\Http\Responses\PaginatedIndexResponse;

class BaseResource
{
	protected array $wheres = [];

	protected array $expands = [];

	protected string $orderBy;

	protected string $orderDirection = 'DESC';

	/**
	 * Used to override urls such as Store, Index etc.
	 * @var array
	 */
	protected array $urlOverrides = [];

	/** @var null|array */
	protected ?array $select = null;

	/** @var string */
	protected const ENDPOINT_BASE = '/';

	/** @var string */
	protected const RESOURCE_KEY = 'item';

	/** @var null|string */
	protected const MODEL = null;

	/** @var null|string */
	protected const RESOURCE_KEY_PLURAL = null;

	public function __construct() { }

	public function __call( $name, $arguments )
	{
		if ( method_exists( $this, $name ) ) {
			return $this->$name( ...$arguments );
		}

		throw new \BadMethodCallException( sprintf( 'Method "%s" does not exist in class %s', $name, static::class ) );
	}

	public function getIndexUrl(): string
	{
		return $this->replaceInUrl( $this->urlOverrides['index'] ?? trim( static::ENDPOINT_BASE, '/' ) );
	}

	public function getShowUrl( $key ): string
	{
		if ( method_exists( $this, 'formatKeyForRequest' ) ) {
			$key = $this->formatKeyForRequest( $key );
		}

		return $this->replaceInUrl( $this->urlOverrides['show'] ?? ( trim( static::ENDPOINT_BASE, '/' ) . '/' . $key ) );
	}

	public function getUpdateUrl( $key ): string
	{
		if ( method_exists( $this, 'formatKeyForRequest' ) ) {
			$key = $this->formatKeyForRequest( $key );
		}

		return $this->replaceInUrl( $this->urlOverrides['update'] ?? $this->getShowUrl( $key ) );
	}

	public function getDeleteUrl( $key ): string
	{
		if ( method_exists( $this, 'formatKeyForRequest' ) ) {
			$key = $this->formatKeyForRequest( $key );
		}

		return $this->replaceInUrl( $this->urlOverrides['delete'] ?? $this->getShowUrl( $key ) );
	}

	public function getStoreUrl(): string
	{
		return $this->replaceInUrl( $this->urlOverrides['store'] ?? $this->getIndexUrl() );
	}

	public function setStoreUrl( string $url ): self
	{
		$this->urlOverrides['store'] = $url;

		return $this;
	}

	protected function get( $page = 1, $perPage = 20, $query = [] )
	{
		$query = array_merge( [ 'page' => $page, 'limit' => $perPage ], $query, $this->wheres );

		if ( ! empty( $this->expands ) ) {
			$query = array_merge( $query, [ 'expand' => implode( ',', $this->expands ) ] );
		}

		if ( is_array( $this->select ) ) {
			$query = array_merge( $query, [ 'fields' => implode( ',', $this->select ) ] );
		}

		if ( ! empty( $this->orderBy ) ) {
			$query['order_by']        = $this->orderBy;
			$query['order_direction'] = $this->orderDirection;
		}

		$responseData = API::http()->get(
			$this->getIndexUrl(),
			$query
		);

		if ( method_exists( $this, 'formatIndexResponse' ) ) {
			return $this->formatIndexResponse( $responseData );
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
				$responseData['limit'],
				$responseData['total'],
			);
		}

		return new IndexResponse( $items );
	}

	protected function all( $query = [] ): IndexResponse
	{
		$response = $this->get( 1, 200, $query );

		if ( $response instanceof PaginatedIndexResponse ) {
			$items = [ $response->items ];

			while ( $response->pages > $response->currentPage ) {
				$response = $this->get( $response->currentPage + 1, 200, $query );
				$items[]  = $response->items;
			}

			return new IndexResponse( array_merge( [], ...$items ) );
		}

		return $response;
	}

	protected function delete( $key, $options = [] )
	{
		return API::http()->delete( $this->getDeleteUrl( $key ), $options );
	}

	protected function find( $key )
	{
		return $this->requestWithSingleItemResponse( function ( $query ) use ( $key ) {
			return API::http()->get( $this->getShowUrl( $key ), $query );
		} );
	}

	protected function first( $query = [], $fallback = null )
	{
		$query = array_merge( [ 'page' => 1, 'limit' => 1 ], $query, $this->wheres );

		if ( ! empty( $this->expands ) ) {
			$query = array_merge( $query, [ 'expand' => implode( ',', $this->expands ) ] );
		}

		if ( is_array( $this->select ) ) {
			$query = array_merge( $query, [ 'fields' => implode( ',', $this->select ) ] );
		}

		if ( ! empty( $this->orderBy ) ) {
			$query['order_by']        = $this->orderBy;
			$query['order_direction'] = $this->orderDirection;
		}

		$responseData = API::http()->get(
			$this->getIndexUrl(),
			$query
		);

		if ( method_exists( $this, 'formatIndexResponse' ) ) {
			return $this->formatIndexResponse( $responseData );
		}

		$items = $responseData[ static::getPluralisedKey() ];

		if ( \count( $items ) === 0 ) {
			return $fallback;
		}

		if ( $model = static::MODEL ) {
			return new $model( $items[0] );
		}

		return $items[0];
	}

	protected function exists(): bool
	{
		$query = array_merge( [ 'page' => 1, 'limit' => 1, 'fields' => 'id' ], $this->wheres );

		$responseData = API::http()->get(
			$this->getIndexUrl(),
			$query
		);

		if ( method_exists( $this, 'formatIndexResponse' ) ) {
			return $this->formatIndexResponse( $responseData );
		}

		return $responseData['total'] > 0;
	}

	protected function update( $key, $data = [] )
	{
		$responseData = API::http()->put(
			$this->getUpdateUrl( $key ),
			$data
		);

		if ( method_exists( $this, 'formatUpdateResponse' ) ) {
			return $this->formatUpdateResponse( $responseData );
		}

		$item = $responseData[ static::getSingularKey() ];

		if ( $model = static::MODEL ) {
			return new $model( $item );
		}

		return $item;
	}

	protected function create( $data = [] )
	{
		$responseData = API::http()->post(
			$this->getStoreUrl(),
			$data
		);

		if ( method_exists( $this, 'formatCreateResponse' ) ) {
			return $this->formatCreateResponse( $responseData );
		}

		$item = $responseData[ static::getSingularKey() ];

		if ( $model = static::MODEL ) {
			return new $model( $item );
		}

		return $item;
	}

	public function where( $key, $value )
	{
		$this->wheres[ $key ] = $value;

		return $this;
	}

	public function expand( $key )
	{
		if ( is_array( $key ) ) {
			foreach ( $key as $item ) {
				if ( ! in_array( $item, $this->expands, true ) ) {
					$this->expands[] = $item;
				}
			}
		} else if ( ! in_array( $key, $this->expands, true ) ) {
			$this->expands[] = $key;
		}

		return $this;
	}

	public function select( $fields = [] )
	{
		$this->select = $fields;

		return $this;
	}

	public function whereCustomField( $id, $value )
	{
		if ( ! isset( $this->wheres['field_eq'] ) ) {
			$this->wheres['field_eq'] = [];
		}

		$this->wheres['field_eq'][ $id ] = $value;

		return $this;
	}

	public function when( $booleanCondition, callable $callback )
	{
		if ( ! empty( $booleanCondition ) ) {
			$callback( $this );
		}

		return $this;
	}

	public function orderBy( string $field, ?string $direction = null )
	{
		$this->orderBy = $field;

		if ( $direction !== null ) {
			$this->orderDirection = $direction;
		}

		return $this;
	}

	public function orderDirection( $direction )
	{
		$this->orderDirection = $direction;

		return $this;
	}

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

	protected function requestWithSingleItemResponse( callable $request )
	{
		$query = array_merge( $this->wheres );

		if ( ! empty( $this->expands ) ) {
			$query = array_merge( $query, [ 'expand' => implode( ',', $this->expands ) ] );
		}

		if ( is_array( $this->select ) ) {
			$query = array_merge( $query, [ 'fields' => implode( ',', $this->select ) ] );
		}

		$responseData = $request( $query );

		$item = $responseData[ static::getSingularKey() ];

		if ( $model = static::MODEL ) {
			return new $model( $item );
		}

		return $item;
	}

	protected function requestWithCollectionResponse( callable $request )
	{
		$query = array_merge( $this->wheres );

		if ( ! empty( $this->expands ) ) {
			$query = array_merge( $query, [ 'expand' => implode( ',', $this->expands ) ] );
		}

		if ( is_array( $this->select ) ) {
			$query = array_merge( $query, [ 'fields' => implode( ',', $this->select ) ] );
		}

		$responseData = $request( $query );

		$items = $responseData[ static::getPluralisedKey() ];

		if ( $model = static::MODEL ) {
			$items = array_map( function ( $item ) use ( $model ) { return new $model( $item ); }, $items );
		}

		if ( isset( $responseData['pages'] ) ) {
			return new PaginatedIndexResponse(
				$items,
				$responseData['pages'],
				$responseData['page'],
				$responseData['limit'],
				$responseData['total'],
			);
		}

		return new IndexResponse( $items );
	}

	protected function getUrlReplacements(): array
	{
		return [];
	}

	protected function replaceInUrl( $url ): string
	{
		foreach ( $this->getUrlReplacements() as $key => $value ) {
			$url = str_replace( '{' . $key . '}', $value, $url );
		}

		return $url;
	}
}