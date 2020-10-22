<?php

namespace RackbeatSDK\Models;

/**
 * @property string       $name
 * @property string       $type
 * @property string       $number
 * @property string       $urlfriendly_number
 * @property float|double $sales_price
 * @property float|double $regular_sales_price
 * @property boolean      $is_custom_sales_price
 * @property float|double $discount_percentage
 * @property string       $price_source
 */
class CustomerProduct extends Model
{
	protected array $casts = [
		'name'                  => 'string',
		'type'                  => 'string',
		'number'                => 'string',
		'urlfriendly_number'    => 'string',
		'sales_price'           => 'double',
		'regular_sales_price'   => 'double',
		'is_custom_sales_price' => 'boolean',
		'discount_percentage'   => 'double',
		'price_source'          => 'string',
	];
}