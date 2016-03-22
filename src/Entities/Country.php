<?php

namespace TradoLogic\Entities;

class Country
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Two-letters country ISO code.
     * Example: 'AF'.
     *
     * @var string
     */
    protected $shortCountryCode;

    /**
     * Three-letters country ISO code.
     * Example: 'AFG'.
     *
     * @var string
     */
    protected $countryCode;

    /**
     * Country name.
     * Example: 'Afghanistan'.
     *
     * @var string
     */
    protected $countryName;

    /**
     * @var int
     */
    protected $lcid;

    /**
     * Three-letters currency ISO code.
     * Example: 'AFN'.
     *
     * @var string
     */
    protected $currency;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getShortCountryCode()
    {
        return $this->shortCountryCode;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return int
     */
    public function getLcid()
    {
        return $this->lcid;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
