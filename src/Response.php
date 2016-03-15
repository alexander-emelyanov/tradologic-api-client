<?php

namespace TradoLogic;

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
                    // Could not validate IP error...
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

    public function isSuccess()
    {
        return $this->getStatusCode() == static::ERROR_NONE;
    }
}