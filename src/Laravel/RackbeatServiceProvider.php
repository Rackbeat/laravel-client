<?php

namespace Rackbeat\Laravel;

use Illuminate\Support\ServiceProvider;
use Rackbeat\API;

class RackbeatServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function boot() {
		$this->publishes( [
			__DIR__ . '/../config/rackbeat.php' => config_path( 'rackbeat.php' ),
		], 'config' );

		$this->app->bind('rackbeat', API::class);
	}

	/**
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom( __DIR__ . '/../config/rackbeat.php', 'rackbeat' );
	}
}