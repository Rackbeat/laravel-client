<?php

use PHPUnit\Framework\TestCase;

class ModelGetterSetterTest extends TestCase
{
	/** @test */
	public function strips_namespaces_by_default() {
		$reader = new \Rackbeat\XmlReader( [ 'attribute_prefix' => 'h' ] );

		$this->assertArrayHasKey( 'root', $reader->fromPath( __DIR__ . '/examples/namespaces.xml' ) );
		$this->assertArrayHasKey( 'table', $reader->fromPath( __DIR__ . '/examples/namespaces.xml' )['root'] );
		$this->assertArrayHasKey( 'tr', $reader->fromPath( __DIR__ . '/examples/namespaces.xml' )['root']['table'] );
		$this->assertArrayHasKey( 'td', $reader->fromPath( __DIR__ . '/examples/namespaces.xml' )['root']['table']['tr'] );
	}
}
