<?php

namespace Aa\ApiTester\ApiTest;


use GuzzleHttp\Psr7\Request;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class SuiteLoader
{
    /**
     * @param $testDirPath
     *
     * @return Suite
     */
    public function loadFromDir($testDirPath)
    {
        $finder = new Finder();
        $files = $finder->files()->in([$testDirPath]);
        
        return $this->loadSuiteFromFiles($files);
    }

    /**
     * @param SplFileInfo[]|array $files
     *
     * @return Suite
     */
    private function loadSuiteFromFiles($files)
    {
        $tests = [];

        foreach ($files as $file) {

            $fileContents = $file->getContents();
            $data = Yaml::parse($fileContents);

            foreach($data['tests'] as $testName => $test) {

                $requestUri = $this->getUri($test);
                $requestBody = $this->getRequestBody($test);
                $requestHeaders = $this->getRequestHeaders($test);
                $request = new Request($test['request']['method'], $requestUri, $requestHeaders, $requestBody);

                $constraints = isset($test['response']['body_constraints']) ? $test['response']['body_constraints'] : null;
                $response = new ResponseExpectation($test['response']['status_code'], [], $constraints);

                $tests[] = new Test($request, $response, [$file->getBasename('.yml'), $testName]);
            }
        }

        $suite = new Suite($tests);

        return $suite;
    }

    /**
     * @param array $test
     *
     * @return string
     */
    private function getUri($test)
    {
        $uri = $test['request']['uri'];
        if (isset($test['request']['query']) && '' !== $test['request']['query']) {
            $uri .= '?'.$test['request']['query'];
        }
        return $uri;
    }

    /**
     * @param array $test
     *
     * @return array
     */
    private function getRequestBody($test)
    {
        $requestBody = null;
        if (isset($test['request']['body'])) {
            if (is_array($test['request']['body'])) {
                $requestBody = json_encode($test['request']['body']);
            }
        }

        return $requestBody;
    }

    /**
     * @param array $test
     *
     * @return array
     */
    private function getRequestHeaders($test)
    {
        $headers = [];
        if (isset($test['request']['headers'])) {
            $headers = $test['request']['headers'];
        }

        return $headers;
    }
}
