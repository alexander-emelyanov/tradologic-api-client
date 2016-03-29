<?php

namespace TradoLogic\Entities;

class Deposit
{
    const STATUS_CONFIRMED = 'Confirmed';

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $affiliateId;

    /**
     * @var string
     */
    protected $depositType;

    /**
     * @var string
     */
    protected $paymentMethod;

    /**
     * @var string
     */
    protected $paymentProvider;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var float
     */
    protected $rateUSD;

    /**
     * @var float
     */
    protected $amountUSD;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var int
     */
    protected $transactionId;

    /**
     * @var int
     */
    protected $requestTime;

    /**
     * @var int
     */
    protected $confirmTime;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getAffiliateId()
    {
        return $this->affiliateId;
    }

    /**
     * @return string
     */
    public function getDepositType()
    {
        return $this->depositType;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return string
     */
    public function getPaymentProvider()
    {
        return $this->paymentProvider;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getRateUSD()
    {
        return $this->rateUSD;
    }

    /**
     * @return float
     */
    public function getAmountUSD()
    {
        return $this->amountUSD;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return int
     */
    public function getRequestTime()
    {
        $oldTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $timestamp = strtotime($this->requestTime);
        date_default_timezone_set($oldTimeZone);

        return $timestamp;
    }

    /**
     * @return int
     */
    public function getConfirmTime()
    {
        $oldTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $timestamp = strtotime($this->confirmTime);
        date_default_timezone_set($oldTimeZone);

        return $timestamp;
    }
}
