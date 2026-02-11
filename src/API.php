<?php

namespace RackbeatSDK;

use Illuminate\Support\Str;
use RackbeatSDK\Concerns\Mocking;
use RackbeatSDK\Exceptions\Client\UserAgentRequiredException;
use RackbeatSDK\Http\HttpEngine;
use RackbeatSDK\Http\MockHttpEngine;
use RackbeatSDK\Resources\CollectionResource;
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

	/** @var HttpEngine|MockHttpEngine|null Instance-level engine for multi-tenant isolation */
	protected $instanceHttpEngine;

	/** @var array Instance-level before hooks */
	protected array $instanceBeforeHooks = [];

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

		$engine = new HttpEngine( [
			'base_uri' 	  => Str::finish( config( 'rackbeat.base_uri' ), '/' ),
			'headers'  	  => $headers,
			'verify'   	  => !config('app.debug'),
			'allow_redirects' => ['strict' => true],
		] );

		// Set static engine for backwards compatibility
		self::$httpEngine = $engine;

		$instance = new self;
		$instance->instanceHttpEngine = $engine;
		$instance->instanceBeforeHooks = self::$beforeHooks;

		// Apply current hooks to the engine instance
		$engine->setBeforeHooks( self::$beforeHooks );

		return $instance;
	}

	public static function mock(): API
	{
		$engine = new MockHttpEngine();

		// Set static engine for backwards compatibility
		self::$httpEngine = $engine;

		$instance = new self;
		$instance->instanceHttpEngine = $engine;
		$instance->instanceBeforeHooks = self::$beforeHooks;

		// Apply current hooks to the mock engine instance
		$engine->setBeforeHooks( self::$beforeHooks );

		return $instance;
	}

	public static function addBeforeHook( callable $callback )
	{
		self::$beforeHooks[] = $callback;
		self::syncBeforeHooksToStaticEngine();
	}

	public static function clearBeforeHooks()
	{
		self::$beforeHooks = [];
		self::syncBeforeHooksToStaticEngine();
	}

	public static function mockResponse( $method, $uri, $response, $statusCode = 200 )
	{
		MockHttpEngine::mockResponse( $method, $uri, $statusCode, $response );
	}

	public static function http(): HttpEngine
	{
		return self::$httpEngine;
	}

	/**
	 * Sync the static before hooks to the static engine (for backwards compatibility).
	 */
	protected static function syncBeforeHooksToStaticEngine()
	{
		if ( self::$httpEngine instanceof HttpEngine ) {
			self::$httpEngine->setBeforeHooks( self::$beforeHooks );
		}
	}

	/**
	 * Add a before hook to this specific API instance.
	 */
	public function addInstanceBeforeHook( callable $callback ): self
	{
		$this->instanceBeforeHooks[] = $callback;

		if ( $this->instanceHttpEngine !== null ) {
			$this->instanceHttpEngine->setBeforeHooks( $this->instanceBeforeHooks );
		}

		return $this;
	}

	/**
	 * Clear before hooks on this specific API instance.
	 */
	public function clearInstanceBeforeHooks(): self
	{
		$this->instanceBeforeHooks = [];

		if ( $this->instanceHttpEngine !== null ) {
			$this->instanceHttpEngine->setBeforeHooks( [] );
		}

		return $this;
	}

	public function setApiToken( $apiToken = null )
	{
		$this->getHttpEngine()->mergeConfig( [
			'headers' => [
				'Authorization' => 'Bearer ' . $apiToken
			]
		] );
	}

	/**
	 * Get the HTTP engine for this instance.
	 * Falls back to the static engine for backwards compatibility.
	 *
	 * @return HttpEngine|MockHttpEngine
	 * @throws \RuntimeException If no HTTP engine has been initialized.
	 */
	public function getHttpEngine()
	{
		$engine = $this->instanceHttpEngine ?? self::$httpEngine;

		if ( $engine === null ) {
			throw new \RuntimeException( 'No HTTP engine available. Call API::make() or API::mock() before using the API.' );
		}

		return $engine;
	}

	public function users()
	{
		return new UserResource( $this->getHttpEngine() );
	}

	public function items()
	{
		return new ItemResource( $this->getHttpEngine() );
	}

	public function lots()
	{
		return new LotResource( $this->getHttpEngine() );
	}

	public function products()
	{
		return new ProductResource( $this->getHttpEngine() );
	}

	public function productGroups()
	{
		return new ProductGroupResource( $this->getHttpEngine() );
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
		return new FieldResource( $this->getHttpEngine() );
	}

	public function orders()
	{
		return new OrderResource( $this->getHttpEngine() );
	}

	public function orderLines( int $orderNumber )
	{
		return new OrderLineResource( $orderNumber, $this->getHttpEngine() );
	}

	public function customerProducts( int $customerNumber )
	{
		return new CustomerProductResource( $customerNumber, $this->getHttpEngine() );
	}

	public function customerInvoices()
	{
		return new CustomerInvoiceResource( $this->getHttpEngine() );
	}

	public function customers()
	{
		return new CustomerResource( $this->getHttpEngine() );
	}

	public function collections()
	{
		return new CollectionResource( $this->getHttpEngine() );
	}
}
