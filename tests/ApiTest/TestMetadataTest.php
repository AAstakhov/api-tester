<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\TestMetadata;
use PHPUnit_Framework_TestCase;

class TestMetadataTest extends PHPUnit_Framework_TestCase
{
    public function testCreateTestMetadata()
    {
        $file = new \SplFileInfo(__FILE__);
        $metadata = new TestMetadata('test', $file);

        $this->assertEquals('test', $metadata->getTestName());
        $this->assertEquals('TestMetadataTest.php', $metadata->getFile()->getBasename());
    }
}
