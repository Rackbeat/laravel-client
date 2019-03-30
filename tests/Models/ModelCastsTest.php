<?php

use PHPUnit\Framework\TestCase;

class ModelGetterSetterTest extends TestCase
{
	/** @test */
	public function can_cast_to_string() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'number' => 1 ], [ 'number' => 'string' ] );

		$this->assertEquals( '1', $model->number );
		$this->assertIsString( $model->number );
	}

	/** @test */
	public function can_cast_to_integer() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'id' => '123' ], [ 'id' => 'int' ] );

		$this->assertEquals( 123, $model->id );
		$this->assertIsInt( $model->id );
	}
}
