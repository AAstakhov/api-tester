<?php

namespace Aa\ApiTester\ApiTest;

use Aa\ApiTester\Response\Validator;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class Runner
{
    private $guzzleClient;

    function __construct($guzzleClient = null)
    {
        if (null === $guzzleClient) {
            $this->guzzleClient = $guzzleClient ?: new Client();
        }
    }


    public function run(Suite $suite)
    {
        /** @var Test $test */
        foreach ($suite as $test) {

            $request = $test->getRequest();
            $response = $this->guzzleClient->send($request);

            $this->validateResponse($response, $test);
        }
    }

    protected function validateResponse(ResponseInterface $response, Test $test)
    {
        $validator = new Validator();
        $violations = $validator->validate($response, $test->getConstraints());

        if(0 !== count($violations)) {
            throw new ValidatorException(sprintf('Test failed'));
        }
    }
}

