<?php

namespace TradoLogic\Requests;

use TradoLogic\Request;

class UserCreate extends Request
{
    public $userPassword;

    public $userFirstName;

    public $userLastName;

    public $currencyCode;

    public $email;

    public $phone;

    public $countryCode;
}