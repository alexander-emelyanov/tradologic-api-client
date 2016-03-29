<?php

namespace TradoLogic\Responses;

use TradoLogic\Entities\Deposit;
use TradoLogic\Payload;
use TradoLogic\Response;

class Deposits extends Response
{
    /**
     * @var array
     */
    protected $deposits = [];

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);

        if ($this->isSuccess()) {
            if (!empty($this->data[static::FIELD_DATA])) {
                foreach ($this->data[static::FIELD_DATA] as $depositInfo) {
                    $this->deposits[] = new Deposit($depositInfo);
                }
            }
        }
    }

    /**
     * @return \TradoLogic\Entities\Deposit[]
     */
    public function getData()
    {
        return $this->deposits;
    }
}
