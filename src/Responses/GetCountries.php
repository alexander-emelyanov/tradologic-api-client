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

    CONST FIELD_CURRENCY = 'currency';

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);

        if ($this->isSuccess()) {
            if (!empty($this->data[static::FIELD_DATA])) {
                foreach ($this->data[static::FIELD_DATA] as $countryInfo) {
                    // Two countries from TradoLogic API have currency.
                    // These countries: "Unknown" and "Antarctica". Real "Tear 1" countries with fat traffic of penguins and nobodies...
                    // But we should skip them...
                    if (isset($countryInfo[static::FIELD_CURRENCY]) && $countryInfo[static::FIELD_CURRENCY]){
                        $this->countries[] = new Country($countryInfo);
                    }
                }
            }
        }
    }

    /**
     * @return \TradoLogic\Entities\Country[]
     */
    public function getData()
    {
        return $this->countries;
    }
}