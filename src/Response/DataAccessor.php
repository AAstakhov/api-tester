<?php


namespace Aa\ApiTester\Response;


use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class DataAccessor
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var array
     */
    private $data;

    /**
     * @param ResponseInterface $response
     */
    function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->data = [
            'status_code' => $this->response->getStatusCode(),
            'headers' => $this->getHeadersAsArray($response),
            'body' => json_decode((string)$this->response->getBody(), true),
        ];
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return $this->data;
    }

    /**
     * @param string $keyPathString
     *
     * @return array
     */
    public function get($keyPathString)
    {
        $keyPath = explode('/', $keyPathString);

        $data =& $this->data;

        foreach ($keyPath as $key) {
            if(!isset($data[$key])) {
                return null;
            }
            $data =& $data[$key];
        }

        return [$keyPathString => $data];
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function getHeadersAsArray(ResponseInterface $response)
    {
        $headers = [];

        foreach($response->getHeaders() as $name => $value) {
            $headers[strtolower($name)] = implode(', ', $value);
        }

        return $headers;
    }
}
