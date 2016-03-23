<?php

namespace TradoLogic\Responses;

use TradoLogic\Exception;
use TradoLogic\Exceptions\EmailAlreadyExistsException;
use TradoLogic\Payload;
use TradoLogic\Response;

class UserGet extends Response
{

    const FIELD_USER_ID = 'id';

    const FIELD_FIRST_NAME = 'firstName';

    const FIELD_LAST_NAME = 'lastName';

    const FIELD_BALANCE = 'balance';

    const FIELD_CURRENCY = 'currency';

    const FIELD_STATUS = 'status';

    const FIELD_CONVERSION_STATUS = 'conversionStatus';

    const FIELD_CONTACTED_DATE = 'contactedDate';

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);
        if (!$this->isSuccess()) {
            switch ($this->getMessageType()) {
                default: {
                    throw new Exception($this, $this->getMessageText());
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getUserId(){
        return $this->data[static::FIELD_USER_ID];
    }

    /**
     * @return string
     */
    public function getFirstName(){
        return $this->data[static::FIELD_FIRST_NAME];
    }

    /**
     * @return string
     */
    public function getLastName(){
        return $this->data[static::FIELD_LAST_NAME];
    }

    /**
     * @return float
     */
    public function getBalance(){
        return $this->data[static::FIELD_BALANCE];
    }

    /**
     * Returns Three-symbols ISO code of user's currency.
     * Example: 'EUR'.
     *
     * @return string
     */
    public function getCurrency(){
        return $this->data[static::FIELD_CURRENCY];
    }

    /**
     * @return string
     */
    public function getConversionStatus(){
        return $this->data[static::FIELD_CONVERSION_STATUS];
    }

    /**
     * @return string
     */
    public function getContactedDate(){
        return $this->data[static::FIELD_CONTACTED_DATE];
    }
}