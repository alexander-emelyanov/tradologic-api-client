<?php

namespace TradoLogic\Responses;

use TradoLogic\Payload;
use TradoLogic\Response;

class UserCreate extends Response
{
    public function __construct(Payload $payload){
        parent::__construct($payload);
    }
}