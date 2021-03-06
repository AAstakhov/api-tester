<?php

namespace Aa\ApiTester\ApiTest;

use Aa\ApiTester\Response\Validator;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class Runner
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var ViolationListFormatter
     */
    private $outputFormatter;

    /**
     * @var string
     */
    private $lastValidationError = '';

    /**
     * @param Client $guzzleClient
     */
    function __construct(Client $guzzleClient = null)
    {
        if (null === $guzzleClient) {
            $config = ['http_errors' => false];
            $this->guzzleClient = $guzzleClient ?: new Client($config);
        }

        $this->outputFormatter = new ViolationListFormatter();
    }

    /**
     * @param Suite $suite
     */
    public function run(Suite $suite)
    {
        /** @var Test $test */
        foreach ($suite as $test) {

            $request = $test->getRequest();
            $response = $this->guzzleClient->send($request);

            $this->validateResponse($response, $test);
        }
    }

    /**
     * @param ResponseInterface $response
     * @param Test              $test
     */
    protected function validateResponse(ResponseInterface $response, Test $test)
    {
        $validator = new Validator();
        $violations = $validator->validate($response, $test->getConstraints());

        if(0 !== count($violations)) {
            $this->lastValidationError = $this->outputFormatter->format($violations, $test->getMetadata());
            throw new ValidatorException(sprintf('Test failed'));
        }
    }

    /**
     * @return string
     */
    public function getLastValidationError()
    {
        return $this->lastValidationError;
    }
}

