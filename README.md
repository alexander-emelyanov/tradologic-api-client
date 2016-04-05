# TradoLogic platform API client

[![Build Status](https://img.shields.io/travis/alexander-emelyanov/tradologic-api-client/master.svg?style=flat-square)](https://travis-ci.org/alexander-emelyanov/tradologic-api-client)
[![StyleCI](https://styleci.io/repos/53869640/shield?)](https://styleci.io/repos/53869640)
[![Code Climate](https://img.shields.io/codeclimate/github/alexander-emelyanov/tradologic-api-client.svg?style=flat-square)](https://codeclimate.com/github/alexander-emelyanov/tradologic-api-client)

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

### Login user

For redirect user to TradoLogic base website you should get Session ID for this user.

```php
$request = new \TradoLogic\Requests\UserLogin([
    'email' => 'alex.emelianov@gmail.com',
    'password' => 'portal',
    'userIpAddress' => '94.74.194.219',
]);

/** @var $response \TradoLogic\Responses\UserLogin */
$response = $client->loginUser($request);

if ($response->isSuccess()) {
    echo ("User logged successfully with Session ID: " . $response->getSessionId() . PHP_EOL);
}
```

### Get deposits

```php
/** @var $response \TradoLogic\Entities\Deposit[] */
$response = $client->deposits();
```

### Get active binary options

For trading integration you must get list of active binary options. You can do it really easy:

```php
/** @var \TradoLogic\Entities\Options\Binary[] $options */
$options = $client->getBinaryOptions();
```

Then you can open positions (binary options) for your customers.

```php
$client->createBinaryOption(new \TradoLogic\Requests\BinaryOptionCreate(<User ID>, <Option ID>, <Volume>, <Is Call>));
```