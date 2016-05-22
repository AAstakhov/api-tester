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
     * @param ResponseInterface  $response
     * @param array|Constraint[]  $constraints
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(ResponseInterface $response, array &$constraints)
    {
        $accessor = new DataAccessor($response);
        $arrayValidator = new ArrayValidator();

        $statusCodeData = $accessor->get('status_code');
        $arrayValidator->setIgnoreItemsWithoutConstraints(false);
        $statusCodeViolations = $arrayValidator->validate($statusCodeData, $constraints);

        $headerData = $accessor->get('headers');
        $arrayValidator->setIgnoreItemsWithoutConstraints(true);
        $headerViolations = $arrayValidator->validate($headerData, $constraints);

        $bodyData = $accessor->get('body');
        $arrayValidator->setIgnoreItemsWithoutConstraints(false);
        $bodyViolations = $arrayValidator->validate($bodyData, $constraints);

        $violations = new ConstraintViolationList();
        $violations->addAll($statusCodeViolations);
        $violations->addAll($headerViolations);
        $violations->addAll($bodyViolations);

        return $violations;
    }
}
