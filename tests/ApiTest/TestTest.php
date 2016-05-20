<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\Test;
use Aa\ApiTester\ApiTest\TestMetadata;
use GuzzleHttp\Psr7\Request;
use PHPUnit_Framework_TestCase;

class TestTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $request = new Request('POST', 'http://aa.aa/aa');
        $constraints = [];

        $metadata = new TestMetadata('aa', new \SplFileInfo(__FILE__));
        $apiTest = new Test($request, $constraints, $metadata);

        $this->assertEquals($request, $apiTest->getRequest());
        $this->assertEquals($metadata, $apiTest->getMetadata());
    }
}
