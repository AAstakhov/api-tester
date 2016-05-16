<?php

namespace Aa\ApiTester\ApiTest;


use Symfony\Component\Finder\Finder;

class SuiteLoader
{
    public function loadFromDir($testDirPath)
    {
        $finder = new Finder();
        $files = $finder->files()->in([$testDirPath]);
        
        return new Suite($files);
    }
}
