<?php

namespace RackbeatSDK\Models;

use RackbeatSDK\Resources\ItemLocationAvailableStockResource;

/**
 * @property string            $type
 * @property string            $number
 * @property string            $urlfriendly_number
 * @property string            $name
 * @property null|ProductGroup $group
 * @property-read \DateTime    $created_at
 * @property-read \DateTime    $updated_at
 */
class Item extends Model
{
	protected string $primaryKey = 'number';
	protected string $keyType    = 'string';

	protected array $casts = [
		'type'               => 'string',
		'number'             => 'string',
		'urlfriendly_number' => 'string',
		'group'              => ProductGroup::class,
	];

	public function getMetadataAttribute( array $value )
	{
		return array_map( function ( $metaObject ) {
			return (object) $metaObject;
		}, $value );
	}

	public function availableLocationStockReport()
	{
		return new ItemLocationAvailableStockResource( $this->urlfriendly_number );
	}
}