<?php

namespace Aa\ApiTester\Tests\ApiTest;

use Aa\ApiTester\ApiTest\TestMetadata;
use Aa\ApiTester\ApiTest\ViolationListFormatter;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class ViolationListFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $formatter = new ViolationListFormatter();

        $violations = new ConstraintViolationList([
            new ConstraintViolation('Hobbit is too small.', '', [], '', 'hobbit/height', 86, null, null, new LessThan(['value' => 100]))
        ]);

        $metadataFile = $this->getMockBuilder('\SplFileInfo')
            ->disableOriginalConstructor()
            ->getMock();
        $metadataFile
            ->expects($this->any())
            ->method('getRealPath')
            ->willReturn('/path/to/hobbits.yml');

        $testMetadata = new TestMetadata('test_hobbit_height', $metadataFile);

        $expected = <<<EOL
Test file: /path/to/hobbits.yml
Test name: test_hobbit_height
    hobbit/height: Hobbit is too small.
        Actual:   86
        Constraint: Symfony\Component\Validator\Constraints\LessThanValidator
            value: 100

EOL;

        $this->assertEquals($expected, $formatter->format($violations, $testMetadata));
    }
}
