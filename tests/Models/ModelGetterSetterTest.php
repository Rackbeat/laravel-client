<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;

class ModelGetterSetterTest extends TestCase
{
	/** @test */
	public function can_get_data_as_properties() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'id' => 1,
		] );

		$this->assertEquals( 1, $model->id );
	}

	/** @test */
	public function can_set_data_fields_in_constructor_with_an_array() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'id'   => 1,
			'name' => 'John Doe',
		] );

		$this->assertEquals( 1, $model->id );
		$this->assertEquals( 'John Doe', $model->name );
	}

	/** @test */
	public function can_set_data_fields_in_constructor_with_a_json_object() {
		$model = \RackbeatSDK\Models\Model::mock( json_decode( json_encode( [
			'id'   => 1,
			'name' => 'John Doe',
		] ) ) );

		$this->assertEquals( 1, $model->id );
		$this->assertEquals( 'John Doe', $model->name );
	}

	/** @test */
	public function can_override_data_directly_with_an_array() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'name' => 'John Doe'
		] );

		$this->assertEquals( 'John Doe', $model->name );

		$model->data = [ 'name' => 'Abe L' ];

		$this->assertEquals( 'Abe L', $model->name );
		$this->assertEmpty( $model->age );

		$model->data = [ 'age' => 55 ];

		$this->assertEquals( 55, $model->age );
	}

	/** @test */
	public function can_override_data_directly_with_a_json_object() {
		$model = \RackbeatSDK\Models\Model::mock( json_decode( json_encode( [
			'name' => 'John Doe'
		] ) ) );

		$this->assertEquals( 'John Doe', $model->name );

		$model->data = json_decode( json_encode( [ 'name' => 'Abe L' ] ) );

		$this->assertEquals( 'Abe L', $model->name );
		$this->assertEmpty( $model->age );

		$model->data = json_decode( json_encode( [ 'age' => 55 ] ) );

		$this->assertEquals( 55, $model->age );
	}

	/** @test */
	public function cannot_override_data_directly_with_a_non_array_or_object_value() {
		$this->expectException( \RackbeatSDK\Exceptions\Models\DataFormatInvalidException::class );
		$model = \RackbeatSDK\Models\Model::mock( [] );

		$model->data = 'not a object nor array';
	}

	/** @test */
	public function can_set_data_from_a_json_string() {
		$model = \RackbeatSDK\Models\Model::mock( '{"name":"John Doe"}' );

		$this->assertEquals( 'John Doe', $model->name );
	}

	/** @test */
	public function cannot_override_original_values() {
		$this->expectException( \RackbeatSDK\Exceptions\Models\ImmutableOriginalDataException::class );

		$model = \RackbeatSDK\Models\Model::mock( [
			'name' => 'John Doe'
		] );

		$model->original = [];
	}

	/** @test */
	public function can_convert_to_array() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'name' => 'John Doe'
		] );

		$this->assertEquals( [
			'name' => 'John Doe'
		], $model->toArray() );
	}

	/** @test */
	public function can_convert_to_object() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'name' => 'John Doe'
		] );

		$this->assertEquals( (object) [
			'name' => 'John Doe'
		], $model->toObject() );
	}

	/** @test */
	public function can_convert_to_json() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'name' => 'John Doe'
		] );

		$this->assertEquals( '{"name":"John Doe"}', $model->toJson() );
	}

	/** @test */
	public function can_get_original_data() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'name' => 'John Doe'
		] );

		$model->name = 'Tony';

		$this->assertEquals( [ 'name' => 'Tony' ], $model->getData() );
		$this->assertEquals( [ 'name' => 'John Doe' ], $model->getOriginal() );
	}

	/** @test */
	public function can_contain_nested_data() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'products' => [
				[ 'id' => 1, 'name' => 'Shoe' ],
				[ 'id' => 84, 'name' => 'Box' ],
				[ 'id' => 2, 'name' => 'Pants' ],
			]
		] );

		$this->assertCount( 3, $model->products );
		$this->assertEquals( $model->products[1]['name'], 'Box' );

		$model->products = [];

		$this->assertCount( 0, $model->products );
	}

	/** @test */
	public function can_contain_arrays_with_objects() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'products' => [
				(object) [ 'id' => 1, 'name' => 'Shoe' ],
				(object) [ 'id' => 84, 'name' => 'Box' ],
				(object) [ 'id' => 2, 'name' => 'Pants' ],
			]
		] );

		$this->assertCount( 3, $model->products );
		$this->assertEquals( $model->products[1]->name, 'Box' );
	}

	/** @test */
	public function can_get_changed_data_for_simple_key_value() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'products' => [
				[ 'id' => 1, 'name' => 'Shoe' ],
			]
		] );

		$this->assertCount( 0, $model->getDirty() );

		$model->products = 'No more products!';

		$this->assertCount( 1, $model->getDirty() );
		$this->assertEquals( 'No more products!', $model->getDirty()['products'] );
	}

	/** @test */
	public function can_get_changed_data_for_nested_data() {
		$model = \RackbeatSDK\Models\Model::mock( [
			'products' => [
				[ 'id' => 1, 'name' => 'Shoe' ],
			]
		] );

		$this->assertCount( 0, $model->getDirty() );

		$model->products = [
			[ 'id' => 2, 'name' => 'Shoe' ],
		];

		$this->assertCount( 1, $model->getDirty() );
	}

	/** @test */
	public function can_undo_dirty_changes() {
		$model = \RackbeatSDK\Models\Model::mock( [ 'name' => 'John' ] );

		$this->assertCount( 0, $model->getDirty() );
		$this->assertEquals( 'John', $model->name );

		$model->name = 'Max';

		$this->assertCount( 1, $model->getDirty() );
		$this->assertEquals( 'Max', $model->getDirty()['name'] );
		$this->assertEquals( 'Max', $model->name );

		$model->cleanup();

		$this->assertCount( 0, $model->getDirty() );
		$this->assertEquals( 'John', $model->name );
	}
}
