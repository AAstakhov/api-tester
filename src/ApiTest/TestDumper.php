<?php

namespace Aa\ApiTester\ApiTest;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Yaml\Yaml;

class TestDumper
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @param Client $guzzleClient
     */
    function __construct(Client $guzzleClient = null)
    {
        if (null === $guzzleClient) {
            $this->guzzleClient = $guzzleClient ?: new Client();
        }
    }

    /**
     * @param Test $test
     *
     * @return string
     */
    public function dump(Test $test)
    {
        $request = $test->getRequest();
        /** @var ResponseInterface $response */
        $response = $this->guzzleClient->send($request);

        $responseData['status_code'] = $response->getStatusCode();
        $rawBody = (string)$response->getBody();
        $body = json_decode($rawBody, true);

        foreach($body as $property => $item) {
            $responseData['body'][$property] = $item;
        };

        $yaml = Yaml::dump($responseData, 100);

        return $yaml;



    }
}
