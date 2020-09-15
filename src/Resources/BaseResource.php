<?php

namespace RackbeatSDK\Resources;

use Illuminate\Support\Str;
use RackbeatSDK\API;
use RackbeatSDK\Http\HttpEngine;

class BaseResource
{
	/** @var null|string */
	protected const ENDPOINT_BASE = null;

	/** @var null|string */
	protected const RESOURCE_KEY = null;

	/** @var null|string */
	protected const RESOURCE_KEY_PLURAL = null;

	/** @var HttpEngine */
	protected HttpEngine $engine;

	public function __construct( HttpEngine $engine )
	{
		$this->engine = $engine;
	}

	public function __call( $name, $arguments )
	{
		if ( method_exists( self, $name ) ) {
			return self::$name( $arguments );
		}
	}

	protected static function index() {
		return API::http()->get(self::ENDPOINT_INDEX ?? self::ENDPOINT_BASE);
	}

	protected static function delete($key) { }

	protected static function find($key) { }

	protected static function update($model) { }

	protected static function create($data = []) { }

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
	protected function getPluralisedKey(): string
	{
		return static::RESOURCE_KEY_PLURAL ?? Str::plural( static::RESOURCE_KEY );
	}
}