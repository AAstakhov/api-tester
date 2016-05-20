<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\TestMetadata;
use PHPUnit_Framework_TestCase;

class TestMetadataTest extends PHPUnit_Framework_TestCase
{
    public function testCreateTestMetadata()
    {
        $metadata = new TestMetadata('test', 'testfile.yml');

        $this->assertEquals('test', $metadata->getTestName());
        $this->assertEquals('testfile.yml', $metadata->getTestFileName());
    }
}
