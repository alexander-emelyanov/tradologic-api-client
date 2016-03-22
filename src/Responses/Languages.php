<?php

namespace TradoLogic\Responses;

use TradoLogic\Entities\Language;
use TradoLogic\Payload;
use TradoLogic\Response;

class Languages extends Response
{
    /**
     * @var array
     */
    protected $languages = [];

    const FIELD_LCID = 'lcid';

    const FIELD_ENGLISH_NAME = 'language';

    const FIELD_NATIVE_NAME = 'display';

    public function __construct(Payload $payload)
    {
        parent::__construct($payload);

        if ($this->isSuccess()) {
            if (!empty($this->data[static::FIELD_DATA])) {
                foreach ($this->data[static::FIELD_DATA] as $languageInfo) {
                    $this->languages[] = new Language(
                        $languageInfo[static::FIELD_LCID],
                        $languageInfo[static::FIELD_ENGLISH_NAME],
                        $languageInfo[static::FIELD_NATIVE_NAME]
                    );
                }
            }
        }
    }

    /**
     * @return \TradoLogic\Entities\Language[]
     */
    public function getData()
    {
        return $this->languages;
    }
}
