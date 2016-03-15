<?php

namespace TradoLogic\Tests;

class CountriesTest extends TestCase
{

    public function testCountries(){
        $countries = $this->apiClient->countries();
        $this->assertNotEmpty($countries, 'Retrieved countries list is empty');
        foreach ($countries as $country) {
            $this->assertNotEmpty($country->getId(), 'Country has not ID');
            $this->assertNotEmpty($country->getCountryCode(), 'Country has not code');
            $this->assertNotEmpty($country->getShortCountryCode(), 'Country has not short code');
            $this->assertNotEmpty($country->getCountryName(), 'Country has not name');
            $this->assertNotEmpty($country->getCurrency(), 'Country has not currency');
            $this->assertNotEmpty($country->getLcid(), 'Country has not lcid');
        }
    }


}