<?php

namespace Aa\ApiTester\Response;

use Psr\Http\Message\ResponseInterface;
use Aa\ArrayValidator\Validator as ArrayValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Validator
{
    const STATUS_CODE_CONSTRAINT_MESSAGE = 'Response status code %s doesn\'t match expected status code %s';

    /**
     * @param ResponseInterface  $response
     * @param array|Constraint[]  $constraints
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(ResponseInterface $response, array $constraints)
    {
        $responseData = $this->getResponseAsArray($response);

        $arrayValidator = new ArrayValidator();
        $violations = $arrayValidator->validate($responseData, $constraints);

        return $violations;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    private function getResponseAsArray(ResponseInterface $response)
    {
        $responseData = [
            'status_code' => $response->getStatusCode(),
            'body' => json_decode((string)$response->getBody(), true),
        ];

        return $responseData;
    }
}
