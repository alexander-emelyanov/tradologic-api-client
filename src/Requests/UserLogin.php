<?php

namespace TradoLogic\Requests;

use TradoLogic\Request;

class UserLogin extends Request
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $userIpAddress;

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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUserIpAddress()
    {
        return $this->userIpAddress;
    }
}
