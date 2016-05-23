<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\SuiteLoader;
use Aa\ApiTester\Exceptions\SuiteLoaderException;
use PHPUnit_Framework_TestCase;

class SuiteLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testLoadFromDir()
    {
        $loader = new SuiteLoader();
        $testSuite = $loader->loadFromDir(__DIR__.'/test-suite');

        $this->assertInstanceOf('\Aa\ApiTester\ApiTest\Suite', $testSuite);
    }

    public function testLoadFromDirIfTestFileHasSyntaxErrorInConstraint()
    {
        $loader = new SuiteLoader();

        try {
            $loader->loadFromDir(__DIR__.'/test-suite-wrong-syntax');
        } catch(SuiteLoaderException $e) {
            $this->assertEquals('test1', $e->getTestName());
            $this->assertEquals('0/name', $e->getKeyPath());
            $this->assertEquals(1, $e->getConstraintIndex());
        }
    }
}
