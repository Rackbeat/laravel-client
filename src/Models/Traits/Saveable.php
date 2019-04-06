<?php

namespace Rackbeat\Models\Traits;

trait Saveable
{
	/**
	 * Indicates if it exists or is newly created.
	 *
	 * @var bool
	 */
	protected $exists = false;

	/**
	 * Indicates if it was just created.
	 *
	 * @var bool
	 */
	protected $wasCreatedRecently = false;

	public function exists(): bool {
		return $this->exists;
	}

	public function save() {
		if ( $this->exists() ) {
			// todo put $this->dirty() values
		} else {
			// todo post $this->toArray()

			$this->exists             = true;
			$this->wasCreatedRecently = true;
		}

		// todo update original & data values

		return $this;
	}
}