<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\ApiTestSuiteLoader;
use PHPUnit_Framework_TestCase;

class ApiTestSuiteLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testLoadFromDir()
    {
        $loader = new ApiTestSuiteLoader();
        $testSuite = $loader->loadFromDir(__DIR__.'/test-suite');

        $this->assertInstanceOf('\Aa\ApiTester\ApiTest\ApiTestSuite', $testSuite);
    }
}
