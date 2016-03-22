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
/** @var \TradoLogic\Entities\Country[] $countries */
$countries = $client->countries();
```

### Get languages list

```php
/** @var \TradoLogic\Entities\Language[] $languages */
$languages = $client->languages();
```

### Create user

For ability to create user your IP should be added to whitelist. So, this operation requires authorization. You should
provide username, password and account ID to \TradoLogic\ApiClient constructor. It should seems like this:

```php
$client = new \TradoLogic\ApiClient([
    'url' => 'https://b2b-api.tradologic.net',
    'username' => '<YOUR_USERNAME>',
    'password' => '<YOUR_PASSWORD>',
    'accountId' => <YOUR_ACCOUNT_ID>,
]);
```

Then you can register user.

```php
$response = $client->createUser(new \TradoLogic\Requests\UserCreate([
    'userPassword' => '<USER_PASSWORD>',
    'userFirstName' => '<USER_FIRST_NAME>',
    'userLastName' => '<USER_LAST_NAME>',
    'phone' => '<USER_PHONE>',
    'email' => '<USER_EMAIL>',
]));
```