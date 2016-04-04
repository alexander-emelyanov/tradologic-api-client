<?php

namespace TradoLogic\Entities\Options;

/**
 * Class Binary.
 */
class Binary
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
     * @return float
     */
    public function getPayout()
    {
        return $this->payout;
    }

    /**
     * @return int
     */
    public function getReturnOnLoss()
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
     * @return string
     */
    public function getTradableAssetGroup()
    {
        return $this->tradableAssetGroup;
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
     * @return int
     */
    public function getDisableInvestTimeInSeconds()
    {
        return $this->disableInvestTimeInSeconds;
    }

    /**
     * @return int
     */
    public function getTradableAssetId()
    {
        return $this->tradableAssetId;
    }

    /**
     * @return string
     */
    public function getTradableAsset()
    {
        return $this->tradableAsset;
    }

    /**
     * @return int
     */
    public function getTradableAssetTypeId()
    {
        return $this->tradableAssetTypeId;
    }

    /**
     * @return string
     */
    public function getTradableAssetType()
    {
        return $this->tradableAssetType;
    }

    /**
     * @var float
     */
    protected $payout;

    /**
     * @var int
     */
    protected $returnOnLoss;

    /**
     * @var int
     */
    protected $optionId;

    /**
     * @var string
     */
    protected $tradableAssetGroup;

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
     * @var int
     */
    protected $disableInvestTimeInSeconds;

    /**
     * @var int
     */
    protected $tradableAssetId;

    /**
     * Example: 'Trip Advisor'.
     *
     * @var string
     */
    protected $tradableAsset;

    /**
     * @var int
     */
    protected $tradableAssetTypeId;

    /**
     * Example: 'Stocks'.
     *
     * @var string
     */
    protected $tradableAssetType;
}
