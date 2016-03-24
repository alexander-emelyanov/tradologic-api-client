<?php

namespace TradoLogic\Tests;
use Monolog\Logger;

class LoggerTest extends TestCase
{
    public function testDummyLogger()
    {
        $logger = new Logger('Logger');
        $this->apiClient->setLogger($logger);
        $languages = $this->apiClient->languages();
        $this->assertNotEmpty($languages, 'Retrieved languages list is empty');
    }
}
