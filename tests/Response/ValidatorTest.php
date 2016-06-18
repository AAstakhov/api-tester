<?php

namespace Aa\ApiTester\Tests\Response;

use Aa\ApiTester\Response\Validator;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidateReturnsNoViolations()
    {
        $validator = new Validator();

        $headers = [
            'content-type' => 'application/json',
            'cache-control' => 'public',
        ];

        $body = [
            'name' => 'Bilbo',
            'height' => '122',
        ];

        $response = new Response(451, $headers, json_encode($body));
        $constraints = [
            'status_code' => [new EqualTo(['value' => 451])],
            'body/name' => [new NotNull()],
            'body/height' => [new GreaterThan(['value' => '100'])],
        ];

        $violations = $validator->validate($response, $constraints);

        $this->assertCount(0, $violations);
    }

    public function testValidateReturnsViolations()
    {
        $validator = new Validator();

        $body = [
            'name' => 'Bilbo',
            'height' => '99',
        ];
        $headers = [
            'content-type' => 'application/json',
            'cache-control' => 'public',
        ];

        $response = new Response(451, $headers, json_encode($body));
        $constraints = [
            'status_code' => [new EqualTo(['value' => 451])],
            'headers/content-type' => [new EqualTo(['value' => 'application/xml'])],
            'body/name' => [new NotNull()],
            'body/height' => [new GreaterThan(['value' => '100'])],
        ];

        $violations = $validator->validate($response, $constraints);

        $this->assertCount(2, $violations);

        $this->assertInstanceOf('\Symfony\Component\Validator\ConstraintViolationInterface', $violations[0]);
        $this->assertEquals('headers/content-type', $violations[0]->getPropertyPath());

        $this->assertInstanceOf('\Symfony\Component\Validator\ConstraintViolationInterface', $violations[1]);
        $this->assertEquals('body/height', $violations[1]->getPropertyPath());
    }
}
