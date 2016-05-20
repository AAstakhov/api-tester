<?php

namespace Aa\ApiTester\Response;

use Psr\Http\Message\ResponseInterface;
use Aa\ArrayValidator\Validator as ArrayValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Validator
{

    /**
     * @param ResponseInterface  $response
     * @param array|Constraint[]  $constraints
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(ResponseInterface $response, array $constraints)
    {
        $accessor = new DataAccessor($response);
        $arrayValidator = new ArrayValidator();

        $violations = $arrayValidator->validate($accessor->asArray(), $constraints);

        return $violations;
    }
}
