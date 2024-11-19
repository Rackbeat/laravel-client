# API Laravel SDK

<p align="center"> 
<a href="https://travis-ci.org/Rackbeat/laravel-client"><img src="https://img.shields.io/travis/Rackbeat/laravel-client.svg?style=flat-square" alt="Build Status"></a>
<a href="https://coveralls.io/github/Rackbeat/laravel-client"><img src="https://img.shields.io/coveralls/Rackbeat/laravel-client.svg?style=flat-square" alt="Coverage"></a>
<a href="https://packagist.org/packages/rackbeat/laravel-client"><img src="https://img.shields.io/packagist/dt/rackbeat/laravel-client.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/rackbeat/laravel-client"><img src="https://img.shields.io/packagist/v/rackbeat/laravel-client.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/rackbeat/laravel-client"><img src="https://img.shields.io/packagist/l/rackbeat/laravel-client.svg?style=flat-square" alt="License"></a>
</p>

## Installation

You just require using composer and you're good to go!

```bash
composer require rackbeat/laravel-client
```

## Usage

Coming soon...

## Testing

The API class comes with a handful of mocking tools. You can mock a response or just assert that endpoints has been called.

### Assert calls has been made
```php
// Set up the API class to use mocking
\Rackbeat\API::mock();

// Has not been called yet 
\Rackbeat\API::assertNotCalled( 'get', '/lots' );

// Make a API call to GET /lots
\Rackbeat\API::lots()->index();

// Has now been called
\Rackbeat\API::assertCalled( 'get', '/lots' );
```

### Mock the response
```php
// Set up the API class to use mocking
\Rackbeat\API::mock();
\Rackbeat\API::mockResponse('GET', '/lots', 'no lots');

// Make a API call to GET /lots
\Rackbeat\API::lots()->index();

// Assert that the response was 'no lots'
\Rackbeat\API::assertResponded( 'get', '/lots', 'no lots' );
```

## Contributors

...

## Requirements
* PHP >= 7.4
* Laravel >= 6.0
