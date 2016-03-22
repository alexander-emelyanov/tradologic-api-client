<?php

namespace TradoLogic;

class Exception extends \Exception
{
    /**
     * @var \TradoLogic\Response
     */
    private $response = null;

    public function __construct(Response $response, $message = '', $code = 0, \Exception $previous = null)
    {
        $exception = parent::__construct($message, $code, $previous);
        $this->response = $response;
        return $exception;
    }

    /**
     * @return \TradoLogic\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}