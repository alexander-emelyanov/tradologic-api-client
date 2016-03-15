<?php

namespace TradoLogic\Entities;

class Language
{
    /**
     * As defined by Microsoft, a locale is either a language or a language in combination with a country.
     * Example: 1033.
     *
     * @var int
     */
    protected $lcid;

    /**
     * English version of language name.
     * Example: 'Italian'.
     *
     * @var string
     */
    protected $englishName;

    /**
     * Native version of language name.
     * Example: 'Italiano'.
     *
     * @var string
     */
    protected $nativeName;

    public function __construct($lcid, $englishName, $nativeName)
    {
        $this->lcid = intval($lcid);
        $this->englishName = trim($englishName);
        $this->nativeName = trim($nativeName);
    }

    /**
     * @return int
     */
    public function getLcid()
    {
        return $this->lcid;
    }

    /**
     * @return string
     */
    public function getEnglishName()
    {
        return $this->englishName;
    }

    /**
     * @return string
     */
    public function getNativeName()
    {
        return $this->nativeName;
    }
}