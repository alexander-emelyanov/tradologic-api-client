<?php

namespace TradoLogic\Responses;

use TradoLogic\Exceptions\EmailAlreadyExistsException;
use TradoLogic\Payload;
use TradoLogic\Response;

class UserCreate extends Response
{
    CONST ERROR_EMAIL_EXISTS = 'Registration_ExistingEmail';

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if (!$this->isSuccess()) {
            switch ($this->getMessageType()) {
                case static::ERROR_EMAIL_EXISTS: {
                    throw new EmailAlreadyExistsException($this, $this->getMessageText());
                }
            }
        }
    }
}
