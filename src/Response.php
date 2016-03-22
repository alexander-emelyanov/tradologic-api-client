<?php

namespace TradoLogic;

use TradoLogic\Exceptions\UnauthorizedException;

class Response
{
    protected $data;

    CONST FIELD_HTTP_STATUS_CODE = 'httpStatusCode';

    CONST FIELD_MESSAGE_TEXT = 'messageText';

    CONST FIELD_DATA = 'data';

    CONST ERROR_NONE = 200;

    CONST ERROR_UNAUTHORIZED = 401;

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
        return null;
    }

    protected function getMessageText()
    {
        if (isset($this->data[static::FIELD_MESSAGE_TEXT])) {
            return $this->data[static::FIELD_MESSAGE_TEXT];
        }
        return null;
    }

    public function isSuccess()
    {
        return $this->getStatusCode() == static::ERROR_NONE;
    }
}