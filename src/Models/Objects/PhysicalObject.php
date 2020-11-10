<?php

namespace RackbeatSDK\Models\Objects;

use RackbeatSDK\Models\Concerns\CastsAttributes;
use RackbeatSDK\Models\Model;

/**
 * Consider change extended class to something not a Model
 *  but maybe something like "Object" which acts as a Model
 *  without the API/data layer (endpoint etc.)
 *
 * @property double $weight
 * @property string $weight_unit
 * @property double $height
 * @property double $width
 * @property double $depth
 * @property string $size_unit
 */
class PhysicalObject extends Model
{
	use CastsAttributes;

	protected array $casts = [
		'weight_unit' => 'string',
		'size_unit'   => 'string',
		'weight'      => 'double',
		'height'      => 'double',
		'width'       => 'double',
		'depth'       => 'double',
	];
}