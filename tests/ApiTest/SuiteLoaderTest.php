<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\SuiteLoader;
use PHPUnit_Framework_TestCase;

class SuiteLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testLoadFromDir()
    {
        $loader = new SuiteLoader();
        $testSuite = $loader->loadFromDir(__DIR__.'/test-suite');

        $this->assertInstanceOf('\Aa\ApiTester\ApiTest\Suite', $testSuite);
    }
}
