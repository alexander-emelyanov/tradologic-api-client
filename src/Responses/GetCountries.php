<?php

namespace TradoLogic\Responses;

use TradoLogic\Entities\Country;
use TradoLogic\Payload;
use TradoLogic\Response;

class GetCountries extends Response
{
    /**
     * @var array
     */
    protected $countries = [];

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);

        if ($this->isSuccess()) {
            if (!empty($this->data[static::FIELD_DATA])){
                foreach ($this->data[static::FIELD_DATA] as $countryInfo) {
                    $this->countries[] = new Country($countryInfo);
                }
            }
        }
    }

    /**
     * @return \TradoLogic\Entities\Country[]
     */
    public function getCountries()
    {
        return $this->countries;
    }
}