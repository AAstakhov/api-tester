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
     * @var TestMetadata
     */
    private $metadata;
    /**
     * @var array|Constraint[]
     */
    private $constraints;

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param array            $constraints
     * @param TestMetadata     $metadata
     */
    public function __construct(RequestInterface $request, array $constraints, TestMetadata $metadata)
    {
        $this->request = $request;
        $this->constraints = $constraints;
        $this->metadata = $metadata;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return TestMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return array|Constraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }
}
