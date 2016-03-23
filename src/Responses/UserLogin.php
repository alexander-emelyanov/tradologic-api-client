<?php

namespace TradoLogic\Responses;

use TradoLogic\Exception;
use TradoLogic\Payload;
use TradoLogic\Response;

class UserLogin extends Response
{
    const FIELD_SESSION_ID = 'sessionId';

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if (!$this->isSuccess()) {
            switch ($this->getMessageType()) {
                default: {
                    throw new Exception($this, $this->getMessageText());
                }
            }
        }
    }

    public function getSessionId()
    {
        $messageParameters = $this->getMessageParameters();

        return $messageParameters[static::FIELD_SESSION_ID];
    }
}