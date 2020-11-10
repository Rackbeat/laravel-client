<?php

namespace RackbeatSDK\Models\Objects;

use RackbeatSDK\Models\Model;

/**
 * Consider change extended class to something not a Model
 *  but maybe something like "Object" which acts as a Model
 *  without the API/data layer (endpoint etc.)
 *
 * @property string $name
 * @property string $city
 * @property string $street
 * @property string $street2
 * @property string $zipcode
 * @property string $country
 * @property string $email
 * @property string $phone
 */
class AddressObject extends Model
{
}