<?php

namespace TradoLogic\Tests;

use Faker\Factory as FakerFactory;
use TradoLogic\ApiClient;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \TradoLogic\ApiClient
     */
    protected $apiClient;

    /**
     * @var \Faker\Generator A Faker fake data generator.
     */
    protected $faker;

    /**
     * Sets up a test with some useful objects.
     */
    public function setUp()
    {
        $url = getenv('TRADOLOGIC_URL');
        if (!$url) {
            throw new \Exception('Environment variable TRADOLOGIC_URL is required');
        }
        $this->apiClient = new ApiClient([
            'url' => $url,
        ]);
        $this->faker = FakerFactory::create();
    }

    /**
     * Free resources.
     */
    public function tearDown()
    {
    }
}
