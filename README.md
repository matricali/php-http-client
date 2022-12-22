[![Latest stable release](https://img.shields.io/badge/dynamic/json.svg?label=stable&url=https%3A%2F%2Fapi.github.com%2Frepos%2Fmatricali%2Fphp-http-client%2Freleases%2Flatest&query=%24.name&colorB=blue)](https://github.com/matricali/php-http-client/releases/latest)
[![Build Status](https://travis-ci.org/matricali/php-http-client.svg?branch=master)](:status:) [![Coverage Status](https://coveralls.io/repos/github/matricali/php-http-client/badge.svg?branch=master)](https://coveralls.io/github/matricali/php-http-client?branch=master)
[![MIT licensed](https://img.shields.io/github/license/matricali/php-http-client.svg)](https://matricali.mit-license.org/2017)
[![GitHub contributors](https://img.shields.io/github/contributors/matricali/php-http-client.svg)](https://github.com/matricali/php-http-client/graphs/contributors)

PSR-7 HTTP Client (cURL)
========================

Note that this is not an HTTP protocol implementation of its own. It is merely a
wrapper of _libcurl_ that implements [PSR-7](http://www.php-fig.org/psr/psr-7/) HTTP message interface.

## Requirements
* PHP 5.4 or newer
* [cURL extension](http://php.net/manual/en/curl.installation.php)

## Installation
```
composer require matricali/http-client
```

## Usage

##### Sending GET request
```
use Matricali\Http\Client;

$client = new Client();
$response = $client->get('http://www.example.com/');

echo $response->getBody();
```

##### Sending POST request
```
use Matricali\Http\Client;

$client = new Client();
$payload = '{"name": "John Doe"}';
$response = $client->post('http://www.example.com/', $payload);

echo $response->getBody();
```

## Contributing

Contributions, issues, pull requests are welcome. See [CONTRIBUTING.md](CONTRIBUTING.md)

## License

php-http-client is [MIT licensed](LICENSE.txt).
