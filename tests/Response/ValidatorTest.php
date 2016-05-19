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

        $body = [
            'name' => 'Bilbo',
            'height' => '122',
        ];

        $response = new Response(451, [], json_encode($body));
        $constraints = [
            'status_code' => new EqualTo(['value' => 451]),
            'body/name' => new NotNull(),
            'body/height' => new GreaterThan(['value' => '100']),
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

        $response = new Response(451, [], json_encode($body));
        $constraints = [
            'status_code' => new EqualTo(['value' => 451]),
            'body/name' => new NotNull(),
            'body/height' => new GreaterThan(['value' => '100']),
        ];

        $violations = $validator->validate($response, $constraints);

        $this->assertCount(1, $violations);
        $this->assertInstanceOf('\Symfony\Component\Validator\ConstraintViolationInterface', $violations[0]);
        $this->assertEquals('body/height', $violations[0]->getPropertyPath());
    }
}
