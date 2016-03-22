<?php

namespace TradoLogic;

use TradoLogic\Exceptions\UnauthorizedException;

class Response
{
    protected $data;

    const FIELD_HTTP_STATUS_CODE = 'httpStatusCode';

    const FIELD_MESSAGE_TYPE = 'messageType';

    const FIELD_MESSAGE_TEXT = 'messageText';

    const FIELD_MESSAGE_PARAMETERS = 'messageParameters';

    const FIELD_DATA = 'data';

    const ERROR_NONE = 200;

    const ERROR_UNAUTHORIZED = 401;

    public function __construct(Payload $payload)
    {
        $this->data = $payload;
        if (!$this->isSuccess()) {
            switch ($this->getStatusCode()) {
                case static::ERROR_UNAUTHORIZED: {
                    throw new UnauthorizedException($this, $this->getMessageText());
                }
            }
        }
    }

    protected function getStatusCode()
    {
        if (isset($this->data[static::FIELD_HTTP_STATUS_CODE])) {
            return $this->data[static::FIELD_HTTP_STATUS_CODE];
        }
    }

    protected function getMessageType()
    {
        if (isset($this->data[static::FIELD_MESSAGE_TYPE])) {
            return $this->data[static::FIELD_MESSAGE_TYPE];
        }
    }

    protected function getMessageText()
    {
        if (isset($this->data[static::FIELD_MESSAGE_TEXT])) {
            return $this->data[static::FIELD_MESSAGE_TEXT];
        }
    }

    protected function getMessageParameters()
    {
        return isset($this->data[static::FIELD_MESSAGE_PARAMETERS]) ? $this->data[static::FIELD_MESSAGE_PARAMETERS] : null;
    }

    public function isSuccess()
    {
        return $this->getStatusCode() == static::ERROR_NONE;
    }
}
