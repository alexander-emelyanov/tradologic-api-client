<?php

namespace TradoLogic;

class Response
{
    protected $data;

    CONST FIELD_HTTP_STATUS_CODE = 'httpStatusCode';

    CONST FIELD_DATA = 'data';

    public function __construct(Payload $payload)
    {
        $this->data = $payload;
    }

    public function isSuccess()
    {
        return (isset($this->data[static::FIELD_HTTP_STATUS_CODE]) && $this->data[static::FIELD_HTTP_STATUS_CODE] == 200);
    }
}