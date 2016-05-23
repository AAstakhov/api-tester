<?php

namespace Aa\ApiTester\Exceptions;

use Exception;
use RuntimeException;

class SuiteLoaderException extends RuntimeException
{
    /**
     * @var string
     */
    private $testFilePath;
    /**
     * @var string
     */
    private $testName;

    /**
     * @var string
     */
    private $keyPath;

    /**
     * @var int
     */
    private $constraintIndex;

    /**
     * @param string    $testFilePath
     * @param string    $testName
     * @param string    $keyPath
     * @param int       $constraintIndex
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($testFilePath, $testName, $keyPath, $constraintIndex, $code = 0, Exception $previous = null)
    {
        $this->testFilePath = $testFilePath;
        $this->testName = $testName;
        $this->keyPath = $keyPath;
        $this->constraintIndex = $constraintIndex;

        $messageFormat = 'Syntax error in %s in test \'%s\', constraint for key \'%s\', line %d';
        $message = sprintf($messageFormat, $testFilePath, $testName, $keyPath, $constraintIndex);

        parent::__construct($message, $code, $previous->getPrevious());
    }

    /**
     * @return string
     */
    public function getTestFilePath()
    {
        return $this->testFilePath;
    }

    /**
     * @return string
     */
    public function getTestName()
    {
        return $this->testName;
    }

    /**
     * @return string
     */
    public function getKeyPath()
    {
        return $this->keyPath;
    }

    /**
     * @return int
     */
    public function getConstraintIndex()
    {
        return $this->constraintIndex;
    }
}
