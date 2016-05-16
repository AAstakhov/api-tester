<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\Test;
use Aa\ApiTester\ApiTest\SuiteLoader;
use PHPUnit_Framework_TestCase;

class SuiteTest extends PHPUnit_Framework_TestCase
{
    public function testGetTests()
    {
        $loader = new SuiteLoader();
        $testSuite = $loader->loadFromDir(__DIR__.'/test-suite');

        /** @var Test $test */
        foreach ($testSuite as $test) {
           $this->assertEquals('hobbits', $test->getTestMetadata()[0]);
        }
    }
}
