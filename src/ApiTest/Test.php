<?php

namespace Aa\ApiTester\ApiTest;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Constraint;

class Test
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $testMetadata;
    /**
     * @var array|Constraint[]
     */
    private $constraints;

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param array            $constraints
     * @param array            $testMetaData
     */
    public function __construct(RequestInterface $request, array $constraints, array $testMetaData)
    {
        $this->request = $request;
        $this->constraints = $constraints;
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
     * @return array
     */
    public function getTestMetadata()
    {
        return $this->testMetadata;
    }

    /**
     * @return array|Constraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

}
