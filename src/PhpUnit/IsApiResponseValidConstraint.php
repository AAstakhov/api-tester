<?php

namespace Aa\ApiTester\PhpUnit;

use Aa\ApiTester\ApiTest\Test;
use Aa\ApiTester\Response\DataAccessor;
use Aa\ApiTester\Response\Validator;
use PHPUnit_Framework_Constraint;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;

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

        $messages = '';

        $messages[] .= sprintf('Test file: %s', $this->test->getMetadata()->getFile()->getRealPath());
        $messages[] .= sprintf('Test name: %s', $this->test->getMetadata()->getTestName());

        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $constraint = $violation->getConstraint();
            $messages[] .= sprintf('    %s: %s', $violation->getPropertyPath(), $violation->getMessage());
            $messages[] .= sprintf('        Actual:   %s', $violation->getInvalidValue());
            $messages[] .= sprintf('        Constraint: %s', $constraint->validatedBy());

            $constraintOptions = [$constraint->getDefaultOption()] + $constraint->getRequiredOptions();
            foreach ($constraintOptions as $option) {
                $messages[] .= sprintf('            %s: %s', $option, $constraint->$option);
            }
        }

        return implode(PHP_EOL, $messages);
    }

    protected function failureDescription($response)
    {
        return 'the returned data '.$this->toString();
    }
}
