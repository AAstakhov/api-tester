<?php

namespace Aa\ApiTester\ApiTest;

use IteratorAggregate;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ApiTestSuite implements IteratorAggregate
{
    /**
     * @var SplFileInfo[]
     */
    private $files;

    /**
     * Constructor.
     * 
     * @param SplFileInfo[] $files
     */
    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
     * @return ApiTest[]
     */
    public function getIterator()
    {
        return $this->getTests();
    }
    
    /**
     * @return ApiTest[]
     */
    public function getTests()
    {
        foreach ($this->files as $file) {

            $fileContents = $file->getContents();
            $data = Yaml::parse($fileContents);
            
            foreach($data['tests'] as $testName => $test) {

                $requestUri = $this->getUri($test);
                $requestBody = $this->getRequestBody($test);
                $requestHeaders = $this->getRequestHeaders($test);
                $request = new Request($test['request']['method'], $requestUri, $requestHeaders, $requestBody);

                $responseBody = isset($test['request']['body']) ? json_encode($test['response']['body']) : null;
                $response = new Response($test['request']['status_code'], [], $responseBody);

                yield new ApiTest($request, $response, $file->getBasename('.yml'), $testName);
            }
        }
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
