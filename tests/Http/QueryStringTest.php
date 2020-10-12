<?php

namespace Tests\Http;

use PHPUnit\Framework\TestCase;
use RackbeatSDK\Http\QueryString;

class QueryStringTest extends TestCase
{
	/** @test */
	public function it_can_generate_a_query_string_from_array()
	{
		$queryString = QueryString::make();

		$queryString->add( 'number', 123 );
		$queryString->add( 'name', 'Testing\' This' );

		$this->assertEquals( 'number=123&name=Testing%27+This', $queryString->build() );
	}

	/** @test */
	public function it_can_have_keyed_arrays_in_query_string()
	{
		$queryString = QueryString::make();

		$queryString->addNested( 'field_eq', 15, 'test' );
		$queryString->addNested( 'field_eq', 10, 'Another Test' );
		$queryString->add( 'number', '123' );

		$this->assertEquals( 'field_eq[15]=test&field_eq[10]=Another+Test&number=123', $queryString->build() );
	}

	/** @test */
	public function it_can_have_multi_level_arrays_in_query_string()
	{
		$queryString = QueryString::make();

		$queryString->add( 'users', [ '1' => [ 'name' => 'John', 'friends' => [ 'None' ] ] ] );

		$this->assertEquals( 'users[1][name]=John&users[1][friends][0]=None', $queryString->build() );
	}
}
