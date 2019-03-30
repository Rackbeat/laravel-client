<?php

namespace Rackbeat\Models\Traits;

trait Updateable
{
	/**
	 * Update specific keys, ignoring dirty changes.
	 *
	 * @param array $data
	 */
	public function update( $data = [] ) { }

	/**
	 * Saves the dirty changes and refreshes the model data.
	 */
	public function save() { }
}