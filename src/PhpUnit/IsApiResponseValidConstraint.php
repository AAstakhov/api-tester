<?php

namespace Aa\ApiTester\PhpUnit;

use Aa\ApiTester\ApiTest\ResponseExpectationInterface;
use Aa\ApiTester\Response\Validator;
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

        $this->validator = new Validator();
        $this->responseExpectation = $responseExpectation;
    }


    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    public function matches($response)
    {
        return 0 == count($this->validator->validate($response, $this->responseExpectation));
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return 'is a valid response';
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     */
    protected function additionalFailureDescription($response)
    {
        $violationMessages = $this->validator->validate($response, $this->responseExpectation);

        return implode("\n", $violationMessages);
    }

    protected function failureDescription($response)
    {
        return 'response returned in the test '.$this->toString();
    }
}
