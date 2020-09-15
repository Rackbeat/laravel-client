<?php

namespace RackbeatSDK\Resources;

use Rackbeat\Http\HttpEngine;

class BaseResource
{
	/** @var string */
	protected const RESOURCE_KEY = 'item';

	/** @var null|string */
	protected const RESOURCE_KEY_PLURAL = null;

	/** @var HttpEngine */
	protected $engine;

	public function __construct( HttpEngine $engine ) {
		$this->engine = $engine;
	}

	/**
	 * Get the resource key, singular.
	 *
	 * @return string
	 */
	protected function getSingularKey(): string {
		return static::RESOURCE_KEY;
	}

	/**
	 * Get the resource key, pluralised.
	 *
	 * Usually appending a "s" should be enough, however for
	 * resources such as "person", we might want to return "people" instead.
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
	protected function getPluralisedKey(): string {
		return static::RESOURCE_KEY_PLURAL ?? ( static::RESOURCE_KEY . 's' );
	}
}