<?php

namespace Aa\ApiTester\ApiTest;

use Aa\ArrayValidator\ConstraintReader;

class ResponseExpectation implements ResponseExpectationInterface
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $constraints;

    /**
     * @param int $statusCode
     * @param array $headers
     * @param array $constraintsDefinitions
     */
    function __construct($statusCode, array $headers, array $constraintsDefinitions)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        $reader = new ConstraintReader();
        $this->constraints = $reader->read($constraintsDefinitions);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBodyConstraints()
    {
        return $this->constraints;
    }
}
