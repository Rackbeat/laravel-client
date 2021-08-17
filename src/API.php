<?php

namespace RackbeatSDK;

use Illuminate\Support\Str;
use RackbeatSDK\Concerns\Mocking;
use RackbeatSDK\Exceptions\Client\UserAgentRequiredException;
use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Http\MockHttpEngine;
use RackbeatSDK\Resources\CustomerInvoiceResource;
use RackbeatSDK\Resources\CustomerProductResource;
use RackbeatSDK\Resources\CustomerResource;
use RackbeatSDK\Resources\FieldResource;
use RackbeatSDK\Resources\ItemResource;
use RackbeatSDK\Resources\LotResource;
use RackbeatSDK\Resources\OrderLineResource;
use RackbeatSDK\Resources\OrderResource;
use RackbeatSDK\Resources\ProductGroupResource;
use RackbeatSDK\Resources\ProductResource;
use RackbeatSDK\Resources\UserResource;

class API
{
	use Mocking;

	/** @var HttpEngine|MockHttpEngine */
	protected static $httpEngine;

	/** @var array */
	protected static array $beforeHooks = [];

	public static function make( $apiToken = null ): API
	{
		if ( empty( config( 'rackbeat.consumer.name' ) ) || empty( config( 'rackbeat.consumer.email' ) ) ) {
			throw new UserAgentRequiredException( 'You must specify an consumer name and contact for validation.' );
		}

		$headers = [
			'API-Version'      => config( 'rackbeat.version' ),
			'Consumer-Name'    => config( 'rackbeat.consumer.name' ),
			'Consumer-Contact' => config( 'rackbeat.consumer.email' ),
			'User-Agent'       => config( 'rackbeat.consumer.name' ) . ' (' . config( 'rackbeat.consumer.email' ) . ')',
			'Content-Type'     => 'application/json; charset=utf8',
			'Accept'           => 'application/json; charset=utf8',
			'connect_timeout'  => 5,
			'timeout'          => 90
		];

		if ( ! empty( $apiToken ) ) {
			$headers['Authorization'] = 'Bearer ' . $apiToken;
		} elseif ( ! empty( config( 'rackbeat.api_token' ) ) ) {
			$headers['Authorization'] = 'Bearer ' . config( 'rackbeat.api_token' );
		}

		self::$httpEngine = new HttpEngine( [
			'base_uri' => Str::finish( config( 'rackbeat.base_uri' ), '/' ),
			'headers'  => $headers
		] );

		self::updateBeforeHooksForClient();

		return new self;
	}

	public static function mock(): API
	{
		self::$httpEngine = new MockHttpEngine();
		self::updateBeforeHooksForClient();

		return new self;
	}

	public static function addBeforeHook( callable $callback )
	{
		self::$beforeHooks[] = $callback;
		self::updateBeforeHooksForClient();
	}

	public static function clearBeforeHooks()
	{
		self::$beforeHooks = [];
		self::updateBeforeHooksForClient();
	}

	public static function mockResponse( $method, $uri, $response, $statusCode = 200 )
	{
		MockHttpEngine::mockResponse( $method, $uri, $statusCode, $response );
	}

	public static function http(): HttpEngine
	{
		return self::$httpEngine;
	}

	protected static function updateBeforeHooksForClient()
	{
		if ( self::$beforeHooks ) {
			self::$httpEngine::setBeforeHooks( self::$beforeHooks );
		}
	}

	public function setApiToken( $apiToken = null )
	{
		$this->httpEngine->mergeConfig( [
			'headers' => [
				'Authorization' => 'Bearer ' . $apiToken
			]
		] );
	}

	public function users()
	{
		return new UserResource();
	}

	public function items()
	{
		return new ItemResource();
	}

	public function lots()
	{
		return new LotResource();
	}

	public function products()
	{
		return new ProductResource();
	}

	public function productGroups()
	{
		return new ProductGroupResource();
	}

	/**
	 * Properly named helper since product group can
	 * be used on Products as well as Lots.
	 *
	 * @return ProductGroupResource
	 */
	public function itemGroups()
	{
		return $this->productGroups();
	}

	public function fields()
	{
		return new FieldResource();
	}

	public function orders()
	{
		return new OrderResource();
	}

	public function orderLines( int $orderNumber )
	{
		return new OrderLineResource( $orderNumber );
	}

	public function customerProducts( int $customerNumber )
	{
		return new CustomerProductResource( $customerNumber );
	}

	public function customerInvoices()
	{
		return new CustomerInvoiceResource();
	}

	public function customers()
	{
		return new CustomerResource();
	}
}