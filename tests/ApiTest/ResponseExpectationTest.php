<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\ResponseExpectation;
use PHPUnit_Framework_TestCase;

class ResponseExpectationTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $constraints = [
            'name' => [0 => 'NotNull'],
        ];

        $responseExpectation = new ResponseExpectation(451, $headers, $constraints);

        $this->assertEquals(451, $responseExpectation->getStatusCode());
        $this->assertCount(2, $responseExpectation->getHeaders());
        $this->assertCount(1, $responseExpectation->getBodyConstraints());
    }
}
