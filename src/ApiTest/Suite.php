<?php

namespace Aa\ApiTester\ApiTest;

use ArrayIterator;
use IteratorAggregate;

class Suite implements IteratorAggregate
{
    /**
     * @var Test[]
     */
    private $tests;

    /**
     * Constructor.
     * 
     * @param Test[] $tests
     */
    public function __construct(array $tests)
    {
        $this->tests = $tests;
    }

    /**
     * @return Test[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->tests);
    }
    
    /**
     * @return Test[]
     */
    public function getTests()
    {
        return $this->tests;
    }
}
