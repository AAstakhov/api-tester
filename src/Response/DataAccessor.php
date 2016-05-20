<?php


namespace Aa\ApiTester\Response;


use Psr\Http\Message\ResponseInterface;

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
            'body' => json_decode((string)$this->response->getBody(), true),
        ];
    }

    public function asArray()
    {
        return $this->data;
    }

    /**
     * @param string $keyPathString
     *
     * @return mixed
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

        return $data;
    }
}
