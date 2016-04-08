<?php

namespace TradoLogic\Entities\Trades;

class Regular
{
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
    protected $tradeId;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $affiliateId;

    /**
     * Example: 'OtherStocks'.
     *
     * @var string
     */
    protected $activeAt;

    /**
     * Example: '2016-04-04T15:30:00.0000000'.
     *
     * @var string
     */
    protected $expireAt;

    /**
     * Example: 'TradeActive'.
     *
     * @var string
     */
    protected $tradeState;

    /**
     * Example: '2016-04-04T15:30:00.0000000'.
     *
     * @var string
     */
    protected $lastUpdated;

    /**
     * @var float
     */
    protected $volume;

    /**
     * @var float
     */
    protected $pl;

    /**
     * Example: 'EUR'.
     *
     * @var string
     */
    protected $currency;

    /**
     * Example: 'AUD/NZD'.
     *
     * @var string
     */
    protected $tradableAsset;

    /**
     * Example: 'Binary'.
     *
     * @var string
     */
    protected $optionType;

    /**
     * @var float
     */
    protected $rate;

    /**
     * @var bool
     */
    protected $call;

    /**
     * Example: 'Put'.
     *
     * @var string
     */
    protected $action;

    /**
     * @var float
     */
    protected $payout;

    /**
     * @var bool
     */
    protected $returnOnLoss;

    /**
     * @var int
     */
    protected $optionId;

    /**
     * @var float
     */
    protected $expiryRate;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @return int
     */
    public function getTradeId()
    {
        return $this->tradeId;
    }

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
     * Returns UNIX TIMESTAMP.
     *
     * @return int
     */
    public function getActiveAt()
    {
        $oldTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $timestamp = strtotime($this->activeAt);
        date_default_timezone_set($oldTimeZone);

        return $timestamp;
    }

    /**
     * Returns UNIX TIMESTAMP.
     *
     * @return int
     */
    public function getExpireAt()
    {
        $oldTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $timestamp = strtotime($this->expireAt);
        date_default_timezone_set($oldTimeZone);

        return $timestamp;
    }

    /**
     * @return string
     */
    public function getTradeState()
    {
        return $this->tradeState;
    }

    /**
     * @return string
     */
    public function getLastUpdated()
    {
        $oldTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $timestamp = strtotime($this->lastUpdated);
        date_default_timezone_set($oldTimeZone);

        return $timestamp;
    }

    /**
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return float
     */
    public function getPl()
    {
        return $this->pl;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getTradableAsset()
    {
        return $this->tradableAsset;
    }

    /**
     * @return string
     */
    public function getOptionType()
    {
        return $this->optionType;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @return bool
     */
    public function isCall()
    {
        return $this->call;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return float
     */
    public function getPayout()
    {
        return $this->payout;
    }

    /**
     * @return bool
     */
    public function isReturnOnLoss()
    {
        return $this->returnOnLoss;
    }

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @return float
     */
    public function getExpiryRate()
    {
        return $this->expiryRate;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}
