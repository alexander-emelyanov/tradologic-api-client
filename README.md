# TradoLogic platform API client

This repository contains PHP Client for TradeSmarter platform.

TradeSmarter is a trading platform for binary options.

## Installation
Install using [Composer](http://getcomposer.org), doubtless.

```sh
$ composer require alexander-emelyanov/tradologic-api-client
```

## Usage

First, you need to create a client object to connect to the TradoLogic servers. You will need to acquire an API username and API password for your app first from broker, then pass the credentials to the client object for logging in. 

```php
$client = new \TradoLogic\ApiClient([
    'url' => 'https://b2b-api.tradologic.net',
]);
```

Assuming your credentials is valid, you are good to go!

### Get countries list

```php
/** @var \TradoLogic\Responses\GetCountries $response */
$response = $client->getCountries();

/** @var \TradoLogic\Entities\Country[] $countries */
$countries = $response->getCountries();
```