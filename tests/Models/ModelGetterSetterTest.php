<?php

use PHPUnit\Framework\TestCase;

class ModelGetterSetterTest extends TestCase
{
	/** @test */
	public function can_set_data_fields_in_constructor_with_an_array() {
		$model = new \Rackbeat\Models\BaseModel( [
			'id'   => 1,
			'name' => 'John Doe',
		] );

		var_dump( $model->getData() );
		$this->assertTrue( true );
	}

	/** @test */
	public function can_set_data_fields_in_constructor_with_an_json_object() {
		$model = new \Rackbeat\Models\BaseModel( json_decode( json_encode( [
			'id'   => 1,
			'name' => 'John Doe',
		] ) ) );

		var_dump( $model->id );
		var_dump( $model->getData() );
		$this->assertTrue( true );
	}

	/** @test */
	public function can_override_data_directly_with_an_array() {
		$model       = new \Rackbeat\Models\BaseModel();
		$model->data = [ 'a' => 'f' ];

		var_dump( $model->getData() );
	}

	/** @test */
	public function can_override_data_directly_with_an_object() { }

	/** @test */
	public function cannot_override_data_directly_with_a_non_array_or_object_value() { }

	/** @test */
	public function cannot_override_original_values() { }
}
