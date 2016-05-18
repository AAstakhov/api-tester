<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\Test;
use GuzzleHttp\Psr7\Request;
use PHPUnit_Framework_TestCase;

class TestTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $request = new Request('POST', 'http://aa.aa/aa');
        $constraints = [];

        $apiTest = new Test($request, $constraints, ['aa', 'test_aa']);

        $this->assertEquals($request, $apiTest->getRequest());
        $this->assertEquals('aa', $apiTest->getTestMetadata()[0]);
        $this->assertEquals('test_aa', $apiTest->getTestMetadata()[1]);
    }
}
