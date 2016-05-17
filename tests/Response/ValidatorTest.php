<?php

namespace Aa\ApiTester\Tests\Response;

use Aa\ApiTester\ApiTest\ResponseExpectation;
use Aa\ApiTester\Response\Validator;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidateReturnsNoViolationMessages()
    {
        $validator = new Validator();

        $body = [
            'name' => 'Bilbo',
            'height' => '122',
        ];

        $response = new Response(451, [], json_encode($body));
        $constraintDefinitions = [
            'name' => ['NotNull'],
            'height' => ['GreaterThan(value="100")'],
        ];

        $responseExpectation = new ResponseExpectation(451, [], $constraintDefinitions);
        $violationMessages = $validator->validate($response, $responseExpectation);

        $this->assertCount(0, $violationMessages);
    }
}
