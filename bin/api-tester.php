<?php

require __DIR__.'/../vendor/autoload.php';

use Aa\ApiTester\ApiTest\Runner;
use Aa\ApiTester\ApiTest\SuiteLoader;


$suiteLoader = new SuiteLoader();
$suite = $suiteLoader->loadFromDir(__DIR__.'/../fixtures');

$runner = new Runner();
$runner->run($suite);
