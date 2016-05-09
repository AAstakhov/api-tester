<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\ApiTest;
use Aa\ApiTester\ApiTest\ApiTestSuiteLoader;
use PHPUnit_Framework_TestCase;

class ApiTestSuiteTest extends PHPUnit_Framework_TestCase
{
    public function testGetTests()
    {
        $loader = new ApiTestSuiteLoader();
        $testSuite = $loader->loadFromDir(__DIR__.'/test-suite');

        /** @var ApiTest $test */
        foreach ($testSuite as $test) {
           $this->assertEquals('hobbits', $test->getTestSetName());
        }
    }
}
