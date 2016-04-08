<?php

namespace TradoLogic\Responses;

use TradoLogic\Entities\Trades\Regular as RegularTrade;
use TradoLogic\Payload;
use TradoLogic\Response;

class RegularUserTradesGet extends Response
{
    /**
     * @var array
     */
    protected $trades = [];

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);

        if ($this->isSuccess()) {
            if (!empty($this->data[static::FIELD_DATA])) {
                foreach ($this->data[static::FIELD_DATA] as $object) {
                    $this->trades[] = new RegularTrade($object);
                }
            }
        }
    }

    /**
     * @return \TradoLogic\Entities\Trades\Regular[]
     */
    public function getData()
    {
        return $this->trades;
    }
}
