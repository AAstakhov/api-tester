<?php

namespace Aa\ApiTester\ApiTest;


use Aa\ApiTester\Exceptions\SuiteLoaderException;
use Aa\ArrayValidator\ConstraintReader;
use Aa\ArrayValidator\Exceptions\ConstraintReaderException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
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

                try {
                    $constraints = [
                        'status_code' => new EqualTo($test['response']['status_code'])
                    ];

                    $headerConstraintDefinitions = isset($test['response']['headers']) ? $test['response']['headers']
                        : [];
                    $constraints += $this->constraintReader->read($headerConstraintDefinitions, 'headers');

                    $bodyConstraintDefinitions = isset($test['response']['body']) ? $test['response']['body'] : [];
                    $constraints += $this->constraintReader->read($bodyConstraintDefinitions, 'body');
                } catch (ConstraintReaderException $exception) {
                    throw new SuiteLoaderException($file->getRealPath(), $testName, $exception->getKeyPath(), $exception->getIndex(), 0, $exception);
                }

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
     * @return Uri
     */
    private function getUri($test)
    {
        $uri = new Uri($test['request']['uri']);

        if (isset($test['request']['query']) && '' !== $test['request']['query']) {
            $query = $uri->getQuery().'&'.$test['request']['query'];
            $uri = $uri->withQuery($query);
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
        $uri = $this->getUri($test);
        $body = $this->getRequestBody($test);
        $headers = $this->getRequestHeaders($test);
        $request = new Request($test['request']['method'], $uri, $headers, $body);

        return $request;
    }
}
