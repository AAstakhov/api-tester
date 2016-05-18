<?php

namespace Aa\ApiTester\PhpUnit;

use Aa\ApiTester\ApiTest\Test;
use Aa\ApiTester\Response\Validator;
use PHPUnit_Framework_Constraint;
use Psr\Http\Message\ResponseInterface;

class IsApiResponseValidConstraint extends PHPUnit_Framework_Constraint
{
    /**
     * @var Test
     */
    private $test;

    /**
     * @param Test $test
     */
    public function __construct(Test $test)
    {
        parent::__construct();

        $this->validator = new Validator();
        $this->test = $test;
    }


    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    public function matches($response)
    {
        return 0 == count($this->validator->validate($response, $this->test->getConstraints()));
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
        $violations = $this->validator->validate($response, $this->test->getConstraints());

        return (string)$violations;
    }

    protected function failureDescription($response)
    {
        return 'response returned in the test '.$this->toString();
    }
}
