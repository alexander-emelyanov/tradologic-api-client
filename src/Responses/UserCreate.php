<?php

namespace TradoLogic\Responses;

use TradoLogic\Exception;
use TradoLogic\Exceptions\EmailAlreadyExistsException;
use TradoLogic\Payload;
use TradoLogic\Response;

class UserCreate extends Response
{
    const ERROR_EMAIL_EXISTS = 'Registration_ExistingEmail';

    const FIELD_USER_ID = 'userId';

    const FIELD_CYSES_REGULATED = 'cySECRegulated';

    const FIELD_SESSION_ID = 'sessionId';

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if (!$this->isSuccess()) {
            switch ($this->getMessageType()) {
                case static::ERROR_EMAIL_EXISTS: {
                    throw new EmailAlreadyExistsException($this, $this->getMessageText());
                }
                default: {
                    throw new Exception($this, $this->getMessageText());
                }
            }
        }
    }

    public function getUserId()
    {
        $messageParameters = $this->getMessageParameters();

        return $messageParameters[static::FIELD_USER_ID];
    }

    public function getCysecRegulated()
    {
        $messageParameters = $this->getMessageParameters();

        return $messageParameters[static::FIELD_CYSES_REGULATED];
    }

    public function getSessionId()
    {
        $messageParameters = $this->getMessageParameters();

        return $messageParameters[static::FIELD_SESSION_ID];
    }
}
