<?php
return [
	/*
	|--------------------------------------------------------------------------
	| Base URI for requests
	|--------------------------------------------------------------------------
	|
	| Useful for switching out the base in case you use a mock server or similar.
	*/
	'base_uri' => 'https://app.rackbeat.com/api',

	/*
	|--------------------------------------------------------------------------
	| API token
	|--------------------------------------------------------------------------
	|
	| If your project uses a single API token, you can fill it here.
	| Alternatively pass it to the class when instantiating the API client.
	*/
	'api_token'  => '',

	/*
	|--------------------------------------------------------------------------
	| API version
	|--------------------------------------------------------------------------
	|
	| API versioning is not yet implemented, but once it is, this will be used.
	| Rackbeat uses a date-based version system, marking our releases by date.
	| A version name could therefor be: 2020-07-26
	*/
	'version'  => 'latest',

	/*
	|--------------------------------------------------------------------------
	| Consumer contact info
	|--------------------------------------------------------------------------
	|
	| Mandatory to fill in. Used for support and to notify in case of problems.
	|
	| Leaving this out long term might get your IP restricted entirely.
	*/
	'consumer' => [
		'name'  => '', // Company / Contact name
		'email' => '', // Company / Contact email
	],
];