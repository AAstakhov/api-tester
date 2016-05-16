<?php

$autoloadPaths = [__DIR__.'/../vendor/autoload.php', __DIR__ . '/../../../autoload.php'];
foreach ($autoloadPaths as $autoloadPath) {
    if (file_exists($autoloadPath)) {
        require $autoloadPath;

        break;
    }
}

use Aa\ApiTester\ApiTest\Runner;
use Aa\ApiTester\ApiTest\SuiteLoader;

$suiteLoader = new SuiteLoader();
$suite = $suiteLoader->loadFromDir($argv[1]);

$runner = new Runner();
$runner->run($suite);
