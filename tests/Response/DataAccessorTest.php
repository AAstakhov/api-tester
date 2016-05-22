<?php

namespace Aa\ApiTester\Tests\Response;

use Aa\ApiTester\Response\DataAccessor;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

class DataAccessorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DataAccessor
     */
    private $accessor;

    public function setUp()
    {
        parent::setUp();

        $headers = [
            'content-type' => 'application/json',
            'cache-control' => 'public',
        ];

        $data = [
            'name' => 'The Lord of the Rings',
            'isbns' => [
                'isbn-10' => '9780007117116',
            ],
        ];

        $response = new Response(451, $headers, json_encode($data));

        $this->accessor = new DataAccessor($response);
    }

    public function testAsArray()
    {
        $expectedData = [
            'status_code' => 451,
            'headers' => [
                'content-type' => 'application/json',
                'cache-control' => 'public',
            ],
            'body' => [
                'name' => 'The Lord of the Rings',
                'isbns' => [
                    'isbn-10' => '9780007117116',
                ]
            ],
        ];

        $this->assertEquals($expectedData, $this->accessor->asArray());
    }

    public function testGetItem()
    {
        $this->assertEquals(['status_code' => 451], $this->accessor->get('status_code'));
        $this->assertEquals(['body/name' => 'The Lord of the Rings'], $this->accessor->get('body/name'));
        $this->assertEquals(['headers/content-type' => 'application/json'], $this->accessor->get('headers/content-type'));
        $this->assertEquals(['headers' => [
            'content-type' => 'application/json',
            'cache-control' => 'public',
        ]], $this->accessor->get('headers'));
        $this->assertEquals(['body/isbns/isbn-10' => '9780007117116'], $this->accessor->get('body/isbns/isbn-10'));
        $this->assertNull($this->accessor->get('whatever'));
        $this->assertNull($this->accessor->get('body/whatever/isbn-10'));
    }

}
