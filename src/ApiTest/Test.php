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
     * @var ResponseInterface
     */
    private $response;
    
    /**
     * @var string
     */
    private $testSetName;
    
    /**
     * @var string
     */
    private $testName;

    /**
     * Constructor.
     * 
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param string $testSetName
     * @param string $testName
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, $testSetName, $testName)
    {
        $this->request = $request;
        $this->response = $response;
        $this->testSetName = $testSetName;
        $this->testName = $testName;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getTestSetName()
    {
        return $this->testSetName;
    }

    /**
     * @return string
     */
    public function getTestName()
    {
        return $this->testName;
    }
}
