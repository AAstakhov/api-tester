<?php

namespace Aa\ApiTester\ApiTest;

use SplFileInfo;

class TestMetadata
{
    /**
     * @var string
     */
    private $testName;

    /**
     * @var SplFileInfo
     */
    private $file;

    /**
     * @param string      $testName
     * @param SplFileInfo $file
     */
    function __construct($testName, SplFileInfo $file)
    {
        $this->testName = $testName;
        $this->file = $file;
    }

    public function getTestName()
    {
        return $this->testName;
    }

    public function getFile()
    {
        return $this->file;
    }
}
