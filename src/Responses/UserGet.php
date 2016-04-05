<?php

namespace TradoLogic\Responses;

use TradoLogic\Exception;
use TradoLogic\Payload;
use TradoLogic\Response;

class UserGet extends Response
{
    const FIELD_USER_ID = 'userId';

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
    public function getUserId()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_USER_ID];
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_FIRST_NAME];
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_LAST_NAME];
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_BALANCE];
    }

    /**
     * Returns Three-symbols ISO code of user's currency.
     * Example: 'EUR'.
     *
     * @return string
     */
    public function getCurrency()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_CURRENCY];
    }

    /**
     * @return string
     */
    public function getConversionStatus()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_CONVERSION_STATUS];
    }

    /**
     * @return string
     */
    public function getContactedDate()
    {
        $data = $this->data->getData()[static::FIELD_DATA];

        return $data[static::FIELD_CONTACTED_DATE];
    }
}
