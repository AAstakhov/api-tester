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
    public function testValidateReturnsNoViolationMessages()
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

        $violationMessages = $validator->validate($response, $constraints);

        $this->assertCount(0, $violationMessages);
    }
}
