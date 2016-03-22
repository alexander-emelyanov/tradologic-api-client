<?php

namespace TradoLogic\Requests;

use TradoLogic\Request;

class UserCreate extends Request
{
    /**
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * @return string
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return int
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * @return string
     */
    public function getUserIpAddress()
    {
        return $this->userIpAddress;
    }

    /**
     * @return string
     */
    public function getSubAffiliateId()
    {
        return $this->subAffiliateId;
    }

    /**
     * @var string
     */
    protected $userPassword;

    /**
     * @var string
     */
    protected $userFirstName;

    /**
     * @var string
     */
    protected $userLastName;

    /**
     * Three-letters currency ISO code in uppercase.
     *
     * @var string
     */
    protected $currencyCode;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var int
     */
    protected $languageCode;

    /**
     * @var string
     */
    protected $userIpAddress;

    /**
     * @var string
     */
    protected $subAffiliateId;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
