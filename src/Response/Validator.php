<?php

namespace Aa\ApiTester\Response;

use Aa\ApiTester\ApiTest\ResponseExpectationInterface;
use Psr\Http\Message\ResponseInterface;
use Aa\ArrayValidator\Validator as ArrayValidator;
use Symfony\Component\Validator\ConstraintViolationInterface;

class Validator
{
    /**
     * @param ResponseInterface            $response
     * @param ResponseExpectationInterface $responseExpectation
     *
     * @return array
     */
    public function validate(ResponseInterface $response, ResponseExpectationInterface $responseExpectation)
    {
        $violationMessages = [];
        if($response->getStatusCode() !== $responseExpectation->getStatusCode()) {
            $violationMessages[] = sprintf('Expected status code: %s', $responseExpectation->getStatusCode());
            $violationMessages[] = sprintf('Actual status code:   %s', $response->getStatusCode());
        }

        $responseData = json_decode((string)$response->getBody(), true);

        $arrayValidator = new ArrayValidator();
        $violations = $arrayValidator->validate($responseData, $responseExpectation->getBodyConstraints());

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $violationMessages[] = '  - '.$violation->getPropertyPath().': '.$violation->getMessage();
        }

        return $violationMessages;
    }
}
