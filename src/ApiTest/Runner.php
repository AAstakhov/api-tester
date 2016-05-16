<?php

namespace Aa\ApiTester\ApiTest;

use Aa\ArrayValidator\Validator;
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

            $this->validateResponse($response, $test->getResponseExpectation(), $test->getTestMetadata());
        }
    }

    protected function validateResponse(ResponseInterface $response, ResponseExpectationInterface $responseExpectation,
        array $testMetadata)
    {

        $cmpStatusCodes = ($response->getStatusCode() !== $responseExpectation->getStatusCode());

        $responseData = json_decode((string)$response->getBody(), true);

        $validator = new Validator();
        $violations = $validator->validate($responseData, $responseExpectation->getBodyConstraints());

        if([] !== $violations) {
            throw new ValidatorException(sprintf('Test failed'));
        }
    }
}

