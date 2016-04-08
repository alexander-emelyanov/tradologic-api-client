<?php

namespace TradoLogic\Requests;

use TradoLogic\Request;

class RegularUserTradesGet extends Request
{
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
    public function getOnlyOpen()
    {
        return $this->onlyOpen;
    }

    /**
     * @var int
     */
    protected $userId;

    /**
     * Contains only 0 or 1.
     *
     * @var int
     */
    protected $onlyOpen;

    /**
     * @param int $userId    Unique identifier of the user in TMS.
     * @param bool $onlyOpen If set to true returns information only about open trades
     */
    public function __construct($userId, $onlyOpen = false)
    {
        parent::__construct([]);
        $this->userId = $userId;
        $this->onlyOpen = intval(boolval($onlyOpen));
    }
}
