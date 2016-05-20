<?php

namespace Aa\ApiTester\ApiTest;

class TestMetadata
{
    /**
     * @var string
     */
    private $testName;
    /**
     * @var string
     */
    private $testFileName;

    /**
     * @param string $testName
     * @param string $testFileName
     */
    function __construct($testName, $testFileName)
    {

        $this->testName = $testName;
        $this->testFileName = $testFileName;
    }

    public function getTestName()
    {
        return $this->testName;
    }

    public function getTestFileName()
    {
        return $this->testFileName;
    }
}
