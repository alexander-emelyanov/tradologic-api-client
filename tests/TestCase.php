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
        $vars = ['url', 'username', 'password', 'accountId'];
        $data = [];
        foreach ($vars as $var) {
            $envVar = strtoupper('TRADOLOGIC_'.strtoupper($var));
            if ($value = getenv($envVar)) {
                $data[$var] = $value;
            } else {
                throw new \Exception("Environment variable $envVar is required");
            }
        }
        $this->apiClient = new ApiClient($data);
        $this->faker = FakerFactory::create();
    }

    /**
     * Free resources.
     */
    public function tearDown()
    {
    }
}
