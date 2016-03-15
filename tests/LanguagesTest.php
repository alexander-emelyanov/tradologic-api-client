<?php

namespace TradoLogic\Tests;

class Languages extends TestCase
{
    public function testLanguages(){
        $languages = $this->apiClient->languages();
        $this->assertNotEmpty($languages, 'Retrieved languages list is empty');
        foreach ($languages as $language) {
            $this->assertGreaterThan(0, $language->getLcid(), 'Locale ID should be greater than 0');
            $this->assertNotEmpty($language->getEnglishName(), 'English name of language should be not empty');
            $this->assertNotEmpty($language->getNativeName(), 'Native name of language should be not empty');
        }
    }
}