<?php

namespace Aa\ApiTester\Response;

use Psr\Http\Message\ResponseInterface;
use Aa\ArrayValidator\Validator as ArrayValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Validator
{
    /**
     * @var ArrayValidator
     */
    private $arrayValidator;

    function __construct()
    {
        $this->arrayValidator = new ArrayValidator();
    }

    /**
     * @param ResponseInterface  $response
     * @param array|Constraint[]  $constraints
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(ResponseInterface $response, array &$constraints)
    {
        $accessor = new DataAccessor($response);

        $statusCodeViolations = $this->validateGroup($accessor, $constraints, 'status_code');
        $headerViolations = $this->validateGroup($accessor, $constraints, 'headers');
        $bodyViolations = $this->validateGroup($accessor, $constraints, 'body');

        $violations = new ConstraintViolationList();
        $violations->addAll($statusCodeViolations);
        $violations->addAll($headerViolations);
        $violations->addAll($bodyViolations);

        return $violations;
    }

    /**
     * @param array  $constraints
     * @param string $group
     *
     * @return array
     */
    private function getConstraintsForGroup(array &$constraints, $group)
    {
        $groupConstraints = [];
        $pattern = sprintf('#^%s(/.*)?#', $group);

        foreach ($constraints as $path => $constraint) {
            if(preg_match($pattern, $path)) {
                $groupConstraints[$path] = $constraint;
            }
        }

        return $groupConstraints;
    }

    /**
     * @param DataAccessor $accessor
     * @param array        $constraints
     * @param string       $group
     *
     * @return ConstraintViolationListInterface
     */
    private function validateGroup(DataAccessor $accessor, array &$constraints, $group)
    {
        $data = $accessor->get($group);
        $ignoreItemsWithoutConstraints = 'headers' === $group;

        $this->arrayValidator->setIgnoreItemsWithoutConstraints($ignoreItemsWithoutConstraints);

        return $this->arrayValidator->validate($data, $this->getConstraintsForGroup($constraints, $group));
    }
}
