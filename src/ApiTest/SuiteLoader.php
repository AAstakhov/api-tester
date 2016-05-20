<?php

namespace Aa\ApiTester\ApiTest;


use Aa\ArrayValidator\ConstraintReader;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Yaml\Yaml;

class SuiteLoader
{
    /**
     * @var ConstraintReader
     */
    private $constraintReader;

    function __construct()
    {
        $this->constraintReader = new ConstraintReader();
    }


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

                $request = $this->createRequest($test);

                $constraints = [
                    'status_code' => new EqualTo($test['response']['status_code'])
                ];

                $constraintDefinitions = isset($test['response']['body']) ? $test['response']['body'] : [];
                $constraints += $this->constraintReader->read($constraintDefinitions, 'body');

                $metadata = new TestMetadata($testName, $file);
                $tests[] = new Test($request, $constraints, $metadata);
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

    /**
     * @param array $test
     *
     * @return RequestInterface
     */
    private function createRequest(array &$test)
    {
        $requestUri = $this->getUri($test);
        $requestBody = $this->getRequestBody($test);
        $requestHeaders = $this->getRequestHeaders($test);
        $request = new Request($test['request']['method'], $requestUri, $requestHeaders, $requestBody);

        return $request;
    }
}
