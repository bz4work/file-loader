<?php
namespace bz4work\fileloader;

/**
 * Class CurlLoader
 * @package bz4work\fileloader
 */
class CurlLoader implements LoaderInterface
{
    private $response_headers;
    private $response_body;

    /**
     * Loading file across HTTP from given url.
     *
     * @param string $url
     * @return mixed
     * @throws \Exception
     */
    public function load($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 20);//timeout 20 sec
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $data = curl_exec($ch);

        if (empty($data)) {
            throw new \Exception('Curl empty response. Check parameters.');
        }

        list($raw_headers, $this->response_body) = explode("\r\n\r\n", $data);

        $this->prepare_headers($raw_headers);

        //Close handler
        curl_close($ch);

        return $this->response_body;
    }

    /**
     * Prepare response HTTP headers.
     *
     * @param string $raw_headers
     * @return mixed
     */
    private function prepare_headers($raw_headers)
    {
        $raw_headers = explode("\r\n", $raw_headers);

        array_walk($raw_headers, function ($item, $key) {
            if(strpos($item, 'HTTP') !== false){
                $parts = explode(' ', $item);
                $this->response_headers['Status'] = trim($parts[1]);
            }else{
                list($header_name, $header_value) = explode(':', $item);
                $this->response_headers[$header_name] = trim($header_value);
            }
        });

        return $this->response_headers;
    }

    /**
     * Get all response header.
     *
     * @return mixed
     */
    public function getResponseHeaders()
    {
        return $this->response_headers;
    }

    /**
     * Get one response header.
     *
     * @param $name
     * @return bool
     */
    public function getHeader($name)
    {
        if(!empty($name) && array_key_exists($name, $this->response_headers)){
            return $this->response_headers[$name];
        }else{
            return false;
        }
    }

    /**
     * Get response body.
     *
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->response_body;
    }
}