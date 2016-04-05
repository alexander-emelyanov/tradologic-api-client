<?php

namespace TradoLogic\Requests;

use TradoLogic\Request;

class BinaryOptionCreate extends Request
{
    const OPTION_TYPE_CALL = 1;

    const OPTION_TYPE_PUT = 0;

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @return int
     */
    public function getIsCall()
    {
        return $this->isCall;
    }

    /**
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @var int
     */
    protected $optionId;

    /**
     * @var int
     */
    protected $isCall;

    /**
     * @var float
     */
    protected $volume;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @param int $userId   Unique identifier of the user in TMS.
     * @param int $optionId Unique identifier of a selected regular option in TMS.
     * @param float $volume Current trade volume of user.
     * @param int $isCall   A flag indicating if user has chosen to Call (1) or not (Put (0)).
     */
    public function __construct($userId, $optionId, $volume, $isCall)
    {
        parent::__construct([]);
        $this->userId = $userId;
        $this->optionId = $optionId;
        $this->volume = floatval($volume);
        $this->isCall = intval((bool)$isCall);
    }
}