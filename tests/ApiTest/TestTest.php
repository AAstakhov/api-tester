<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\Test;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

class TestTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $request = new Request('POST', 'http://aa.aa/aa');
        $response = new Response(200);

        $apiTest = new Test($request, $response, 'aa', 'test_aa');

        $this->assertEquals($request, $apiTest->getRequest());
        $this->assertEquals($response, $apiTest->getResponse());
        $this->assertEquals('aa', $apiTest->getTestSetName());
        $this->assertEquals('test_aa', $apiTest->getTestName());
    }
}
