**~~~~~~ BY NO MEANS READY YET! ~~~~~~**

# API Laravel SDK

<p align="center"> 
<a href="https://travis-ci.org/Rackbeat/php-sdk"><img src="https://img.shields.io/travis/Rackbeat/php-sdk.svg?style=flat-square" alt="Build Status"></a>
<a href="https://coveralls.io/github/Rackbeat/php-sdk"><img src="https://img.shields.io/coveralls/Rackbeat/php-sdk.svg?style=flat-square" alt="Coverage"></a>
<a href="https://packagist.org/packages/rackbeat/php-sdk"><img src="https://img.shields.io/packagist/dt/rackbeat/php-sdk.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/rackbeat/php-sdk"><img src="https://img.shields.io/packagist/v/rackbeat/php-sdk.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/rackbeat/php-sdk"><img src="https://img.shields.io/packagist/l/rackbeat/php-sdk.svg?style=flat-square" alt="License"></a>
</p>

## Installation

You just require using composer and you're good to go!

```bash
composer require rackbeat/php-sdk
```

## Usage

Coming soon...

## Testing

The API class comes with a handful of mocking tools. You can mock a response or just assert that endpoints has been called.

### Assert calls has been made
```php
\Rackbeat\API::mock(); // Set up the API class to use mocking

// Has not been called yet 
\Rackbeat\API::assertNotCalled( 'get', '/lots' );

\Rackbeat\API::lots()->index();

// Has now been called
\Rackbeat\API::assertCalled( 'get', '/lots' );
```

## Contributors

...

## Requirements
* PHP >= 7.4
* Laravel >= 6.0
