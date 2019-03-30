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

	/** @test */
	public function can_cast_atomstring_to_datetime() {
		$model = \Rackbeat\Models\BaseModel::mock( [ 'created_at' => '2018-01-01T18:30:00+01:00' ] );

		$dateTime = new DateTime();
		$dateTime->setTimezone( new DateTimeZone( '+01:00' ) );
		$dateTime->setDate( 2018, 01, 01 );
		$dateTime->setTime( 18, 30, 00 );

		$this->assertEquals( $dateTime, $model->created_at );
	}
}
