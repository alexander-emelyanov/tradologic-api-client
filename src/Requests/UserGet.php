<?php

namespace TradoLogic\Requests;

use TradoLogic\Request;

class UserGet extends Request
{
    /**
     * @var int
     */
    protected $userId;

    public function getUserId()
    {
        return $this->userId;
    }
}
