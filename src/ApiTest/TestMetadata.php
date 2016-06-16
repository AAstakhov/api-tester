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

    /**
     * @return string
     */
    public function getTestName()
    {
        return $this->testName;
    }

    /**
     * @return SplFileInfo
     */
    public function getFile()
    {
        return $this->file;
    }
}
