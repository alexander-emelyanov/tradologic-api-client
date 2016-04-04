<?php

namespace TradoLogic\Responses;

use TradoLogic\Entities\Options\Binary;
use TradoLogic\Payload;
use TradoLogic\Response;

class BinaryOptions extends Response
{
    /**
     * @var array
     */
    protected $binaryOptions = [];

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);

        if ($this->isSuccess()) {
            if (!empty($this->data[static::FIELD_DATA])) {
                foreach ($this->data[static::FIELD_DATA] as $object) {
                    $this->binaryOptions[] = new Binary($object);
                }
            }
        }
    }

    /**
     * @return \TradoLogic\Entities\Options\Binary[]
     */
    public function getData()
    {
        return $this->binaryOptions;
    }
}
