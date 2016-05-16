<?php

namespace Aa\ApiTester\PhpUnit;

use Aa\ApiTester\ApiTest\ResponseExpectationInterface;
use PHPUnit_Framework_Constraint;
use Psr\Http\Message\ResponseInterface;

class IsApiResponseValidConstraint extends PHPUnit_Framework_Constraint
{
    /**
     * @var ResponseExpectationInterface
     */
    private $responseExpectation;

    public function __construct(ResponseExpectationInterface $responseExpectation)
    {
        parent::__construct();

        $this->responseExpectation = $responseExpectation;
    }

    /**
     * @inheritdoc
     */
    public function matches($response)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return 'is a valid response';
    }
}
