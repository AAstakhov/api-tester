<?php
namespace Aa\ApiTester\ApiTest;

use Symfony\Component\Validator\Constraint;

interface ResponseExpectationInterface
{
    /**
     * Gets the expected response status code.
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * @return array Returns an associative array of the headers
     */
    public function getHeaders();

    /**
     * @return array|Constraint[] Returns an associative array of the constraints
     */
    public function getBodyConstraints();
}
