<?php

use PHPUnit\Framework\TestCase;

class ModelCastsTest extends TestCase
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

	/** @test */
	public function can_cast_to_integer_from_float() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'amount' => 1.123 ], [ 'amount' => 'int' ] );

		$this->assertEquals( 1, $model->amount );
		$this->assertIsInt( $model->amount );
	}

	/** @test */
	public function can_cast_atomstring_to_datetime() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'created_at' => '2018-01-01T18:30:00+01:00' ], [ 'created_at' => 'datetime' ] );

		$comparisonDateTime = new DateTime();
		$comparisonDateTime->setTimezone( new DateTimeZone( '+01:00' ) );
		$comparisonDateTime->setDate( 2018, 01, 01 );
		$comparisonDateTime->setTime( 18, 30, 00 );

		$this->assertEquals( $comparisonDateTime, $model->created_at );
	}

	/** @test */
	public function can_cast_to_boolean() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'is_booked' => 0 ], [ 'is_booked' => 'boolean' ] );

		$this->assertFalse( $model->is_booked );

		$model->is_booked = 1;

		$this->assertTrue( $model->is_booked );
	}

	/** @test */
	public function can_cast_to_double() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'amount' => '0.15' ], [ 'amount' => 'double' ] );

		$this->assertEquals( 0.15, $model->amount );
	}

	/** @test */
	public function can_cast_to_float() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'amount' => '0.15' ], [ 'amount' => 'float' ] );

		$this->assertEquals( 0.15, $model->amount );
	}

	/** @test */
	public function can_cast_to_array() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'customer' => (object) [ 'name' => 'John Doe' ] ], [ 'customer' => 'array' ] );

		$this->assertIsArray( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer['name'] );
	}

	/** @test */
	public function can_cast_to_object() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'customer' => [ 'name' => 'John Doe' ] ], [ 'customer' => 'object' ] );

		$this->assertIsObject( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer->name );
	}

	/** @test */
	public function can_cast_to_json() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'customer' => [ 'name' => 'John Doe' ] ], [ 'customer' => 'json' ] );

		$this->assertIsString( $model->customer );
		$this->assertEquals( '{"name":"John Doe"}', $model->customer );
	}

	/** @test */
	public function can_cast_to_array_from_json() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'customer' => '{"name":"John Doe"}' ], [ 'customer' => 'array' ] );

		$this->assertIsArray( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer['name'] );
	}

	/** @test */
	public function can_cast_to_object_from_json() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'customer' => '{"name":"John Doe"}' ], [ 'customer' => 'object' ] );

		$this->assertIsObject( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer->name );
	}
}
