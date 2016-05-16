<?php

namespace Aa\ApiTester\ApiTest;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Test
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseExpectationInterface
     */
    private $responseExpectation;

    /**
     * @var array
     */
    private $testMetadata;

    /**
     * Constructor.
     *
     * @param RequestInterface             $request
     * @param ResponseExpectationInterface $responseExpectation
     * @param array                        $testMetaData
     */
    public function __construct(RequestInterface $request, ResponseExpectationInterface $responseExpectation, array $testMetaData)
    {
        $this->request = $request;
        $this->responseExpectation = $responseExpectation;
        $this->testMetadata = $testMetaData;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ResponseExpectationInterface
     */
    public function getResponseExpectation()
    {
        return $this->responseExpectation;
    }

    /**
     * @return array
     */
    public function getTestMetadata()
    {
        return $this->testMetadata;
    }

}
