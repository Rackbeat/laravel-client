<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use RackbeatSDK\Models\Order;

class ModelCastsTest extends TestCase
{
	/** @test */
	public function can_cast_to_string()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'number' => 1 ], [ 'number' => 'string' ] );

		$this->assertEquals( '1', $model->number );
		$this->assertIsString( $model->number );
	}

	/** @test */
	public function can_cast_to_integer()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'id' => '123' ], [ 'id' => 'int' ] );

		$this->assertEquals( 123, $model->id );
		$this->assertIsInt( $model->id );
	}

	/** @test */
	public function can_cast_to_integer_from_float()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'amount' => 1.123 ], [ 'amount' => 'int' ] );

		$this->assertEquals( 1, $model->amount );
		$this->assertIsInt( $model->amount );
	}

	/** @test */
	public function can_cast_atomstring_to_datetime()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'created_at' => '2018-01-01T18:30:00+01:00' ], [ 'created_at' => 'datetime' ] );

		$comparisonDateTime = new \DateTime();
		$comparisonDateTime->setTimezone( new \DateTimeZone( '+01:00' ) );
		$comparisonDateTime->setDate( 2018, 01, 01 );
		$comparisonDateTime->setTime( 18, 30, 00 );

		$this->assertEquals( $comparisonDateTime, $model->created_at );
	}

	/** @test */
	public function can_cast_datetime_to_datetime()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'created_at' => $dateTime = new \DateTime( '2018-01-01T18:30:00+01:00' ) ], [ 'created_at' => 'datetime' ] );

		$this->assertEquals( $dateTime, $model->created_at );
	}

	/** @test */
	public function can_cast_to_boolean()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'is_booked' => 0 ], [ 'is_booked' => 'boolean' ] );

		$this->assertFalse( $model->is_booked );

		$model->is_booked = 1;

		$this->assertTrue( $model->is_booked );
	}

	/** @test */
	public function can_cast_to_double()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'amount' => '0.15' ], [ 'amount' => 'double' ] );

		$this->assertEquals( 0.15, $model->amount );
	}

	/** @test */
	public function can_cast_to_float()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'amount' => '0.15' ], [ 'amount' => 'float' ] );

		$this->assertEquals( 0.15, $model->amount );
	}

	/** @test */
	public function can_cast_to_array()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'customer' => (object) [ 'name' => 'John Doe' ] ], [ 'customer' => 'array' ] );

		$this->assertIsArray( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer['name'] );
	}

	/** @test */
	public function can_cast_to_object()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'customer' => [ 'name' => 'John Doe' ] ], [ 'customer' => 'object' ] );

		$this->assertIsObject( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer->name );
	}

	/** @test */
	public function can_cast_to_json()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'customer' => [ 'name' => 'John Doe' ] ], [ 'customer' => 'json' ] );

		$this->assertIsString( $model->customer );
		$this->assertEquals( '{"name":"John Doe"}', $model->customer );
	}

	/** @test */
	public function can_cast_to_array_from_json()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'customer' => '{"name":"John Doe"}' ], [ 'customer' => 'array' ] );

		$this->assertIsArray( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer['name'] );
	}

	/** @test */
	public function can_cast_to_object_from_json()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'customer' => '{"name":"John Doe"}' ], [ 'customer' => 'object' ] );

		$this->assertIsObject( $model->customer );
		$this->assertEquals( 'John Doe', $model->customer->name );
	}

	/** @test */
	public function can_cast_datetime_back_to_atom()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'created_at' => $date = new \DateTime( '2018-01-01T18:30:00+01:00' ) ], [ 'created_at' => 'datetime' ] );

		$this->assertEquals( $date, $model->created_at );

		$model = \RackbeatSDK\Models\Model::mock( [ 'created_at' => $newDate = new \DateTime( '2019-01-01T18:30:00+01:00' ) ], [ 'created_at' => 'datetime' ] );

		$dateString = $newDate->format( 'Y-m-d\TH:i:sP' );

		$this->assertInstanceOf( \Carbon\Carbon::class, $model->toArray()['created_at'] );
		$this->assertEquals( $dateString, $model->toArray()['created_at']->format( 'Y-m-d\TH:i:sP' ) );

		$this->assertEquals( $dateString, $model->getData()['created_at'] );
		$this->assertEquals( $dateString, $model->toObject()->created_at );
		$this->assertEquals( '{"created_at":"' . $dateString . '"}', $model->toJson() );
	}

	/** @test */
	public function can_cast_to_and_from_date()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'shipped_at' => $dateTime = new \DateTime( '2018-01-01T18:30:00+01:00' ) ], [ 'shipped_at' => 'date' ] );

		$this->assertEquals( $dateTime->setTimezone( new \DateTimeZone( '+00:00' ) )->setTime( 0, 0, 0 ), $model->shipped_at );

		$model->shipped_at = ( $newDate = new \DateTime( '2019-01-01T18:30:00+01:00' ) );

		$dateString = $newDate->format( 'Y-m-d' );

		$this->assertInstanceOf( \Carbon\Carbon::class, $model->toArray()['shipped_at'] );
		$this->assertEquals( $dateString, $model->toArray()['shipped_at']->format( 'Y-m-d' ) );

		$this->assertEquals( $dateString, $model->getData()['shipped_at'] );
		$this->assertEquals( $dateString, $model->toObject()->shipped_at );
		$this->assertEquals( '{"shipped_at":"' . $dateString . '"}', $model->toJson() );
	}

	/** @test */
	public function can_cast_to_model()
	{
		$model = \RackbeatSDK\Models\Model::mock( [ 'order' => [ 'number' => 12345 ] ], [ 'order' => Order::class ] );

		$this->assertInstanceOf( Order::class, $model->order );
		$this->assertEquals( 12345, $model->order->number );

		$this->assertEquals( [ 'order' => [ 'number' => 12345 ] ], $model->toArray() );
		$this->assertEquals( '{"order":{"number":12345}}', $model->toJson() );

		$object = new \stdClass();
		$object->order = new \stdClass();
		$object->order->number = 12345;

		$this->assertEquals( $object, $model->toObject() );
	}
}
