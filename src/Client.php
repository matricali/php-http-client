<?php
/*
Copyright (c) 2017 Jorge Matricali <jorgematricali@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

namespace Matricali\Http;

use Psr\Http\Message\RequestInterface;
use Matricali\Http\Client\Exception as ClientException;

class Client implements ClientInterface
{
    const VERSION = '1.1';

    protected $handle = null;
    protected $responseHeader = '';
    protected $responseHeaders = [];
    protected $statusCode;
    protected $version;

    /**
     * Client constructor.
     *
     * @throws ClientException
     */
    public function __construct()
    {
        $this->handle = curl_init();

        if (!is_resource($this->handle)) {
            throw new ClientException(curl_error($this->handle), 'curl');
        }

        $this->setOptions([
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_AUTOREFERER     => true,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_MAXREDIRS       => 20,
            CURLOPT_HEADER          => false,
            CURLOPT_PROTOCOLS       => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_USERAGENT       => 'jorge-matricali/php-http-client HTTP/' . self::VERSION . ' (libcurl)',
            CURLOPT_CONNECTTIMEOUT  => 30,
            CURLOPT_TIMEOUT         => 30,
        ]);
    }

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            curl_close($this->handle);
        }
    }

    /**
     * headerFunction.
     *
     * @param $handler
     * @param $line
     * @return int
     */
    public function headerFunction($handler, $line)
    {
        $this->responseHeader .= $line;
        return strlen($line);
    }

    /**
     * __clone.
     *
     * @return Client
     * @throws ClientException
     */
    public function __clone()
    {
        $client = new self;
        $client->handle = curl_copy_handle($this->handle);
        return $client;
    }

    /**
     * setOptions.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        if (is_array($options) && count($options) > 0) {
            curl_setopt_array($this->handle, $options);
        }
    }

    /**
     * parseHeaders.
     *
     * @param $lines
     * @return array|bool
     */
    protected function parseHeaders($lines)
    {
        if (empty($lines)) {
            return [];
        }
        if (is_string($lines)) {
            $lines = array_filter(explode("\r\n", $lines));
        } elseif (!is_array($lines)) {
            return false;
        }

        $status = [];
        if (preg_match('%^HTTP/(\d(?:\.\d)?)\s+(\d{3})\s?+(.+)?$%i', $lines[0], $status)) {
            $this->status = $status[0];
            $this->version = $status[1];
            $this->statusCode = intval($status[2]);
            $this->statusMessage = isset($status[3]) ? $status[3] : '';
        }

        foreach ($lines as $field) {
            if (!is_array($field)) {
                $field = array_map('trim', explode(':', $field, 2));
            }
            if (count($field) == 2) {
                $this->responseHeaders[$field[0]] = $field[1];
            }
        }

        return $this->responseHeaders;
    }

    /**
     * sendRequest.
     *
     * @param RequestInterface $request
     * @return Response
     * @throws ClientException
     */
    public function sendRequest(RequestInterface $request)
    {
        curl_setopt($this->handle, CURLOPT_URL, (string) $request->getUri());
        curl_setopt($this->handle, CURLOPT_HEADERFUNCTION, [$this, 'headerFunction']);

        foreach ($request->getHeaders() as $name => $values) {
            $headers[] = $name . ': ' . implode(', ', $values);
        }
        if (isset($headers)) {
            curl_setopt($this->handle, CURLOPT_HTTPHEADER, $headers);
        }

        $method = $request->getMethod();
        switch($method) {
            case HttpMethod::HEAD:
                curl_setopt($this->handle, CURLOPT_NOBODY, true);
                break;
            case HttpMethod::POST:
                curl_setopt($this->handle, CURLOPT_POST, true);
                $body = $request->getBody();
                if (!empty($body)) {
                    curl_setopt($this->handle, CURLOPT_POSTFIELDS, $body);
                }
                break;
            case HttpMethod::PUT:
            case HttpMethod::PATCH:
            case HttpMethod::DELETE:
                curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, $method);
                break;
        }

        $ret = curl_exec($this->handle);

        if ($errno = curl_errno($this->handle)) {
            throw new ClientException(curl_error($this->handle), $errno);
        }

        $this->parseHeaders($this->responseHeader);

        return new Response($ret, $this->statusCode, $this->responseHeaders, $this->version);
    }

    /**
     * Create a GET request for the client
     *
     * @param string $uri Resource URI.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     * @throws ClientException
     */
    public function get($uri, array $headers = array(), array $options = array())
    {
        $this->setOptions($options);
        return $this->sendRequest(new Request(HttpMethod::GET, $uri, $headers));
    }

    /**
     * Create a HEAD request for the client
     *
     * @param string $uri Resource URI.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     * @throws ClientException
     */
    public function head($uri, array $headers = array(), array $options = array())
    {
        $this->setOptions($options);
        return $this->sendRequest(new Request(HttpMethod::HEAD, $uri, $headers));
    }

    /**
     * Create a POST request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     * @throws ClientException
     */
    public function post($uri, $body = '', array $headers = array(), array $options = array())
    {
        $this->setOptions($options);
        return $this->sendRequest(new Request(HttpMethod::POST, $uri, $headers, $body));
    }

    /**
     * Create a PUT request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     * @throws ClientException
     */
    public function put($uri, $body = '', array $headers = array(), array $options = array())
    {
        $this->setOptions($options);
        return $this->sendRequest(new Request(HttpMethod::PUT, $uri, $headers, $body));
    }

    /**
     * Create a DELETE request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     * @throws ClientException
     */
    public function delete($uri, $body = '', array $headers = array(), array $options = array())
    {
        $this->setOptions($options);
        return $this->sendRequest(new Request(HttpMethod::DELETE, $uri, $headers, $body));
    }

    /**
     * Create a PATCH request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     * @throws ClientException
     */
    public function patch($uri, $body = '', array $headers = array(), array $options = array())
    {
        $this->setOptions($options);
        return $this->sendRequest(new Request(HttpMethod::PATCH, $uri, $headers, $body));
    }
}
