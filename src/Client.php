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
use Psr\Http\Message\ResponseInterface;

use Matricali\Http\Client\Exception as ClientException;

class Client
{
    const VERSION = '1.1';

    protected $handle = null;
    protected $responseHeader = '';
    protected $responseHeaders = [];

    public function __construct()
    {
        $this->handle = curl_init();

        if (!is_resource($this->handle)) {
            throw new ClientException(curl_error($this->handle), 'curl');
        }

        curl_setopt_array($this->handle, [
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
        curl_close($this->handle);
    }

    public function headerFunction($handler, $line)
    {
        $this->responseHeader .= $line;
        return strlen($line);
    }

    public function __clone()
    {
        $client = new self;
        $client->handle = curl_copy_handle($this->handle);
        return $client;
    }

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
            $this->status = array_shift($lines);
            $this->version = $lines[1];
            $this->statusCode = intval($lines[2]);
            $this->statusMessage = isset($lines[3]) ? $lines[3] : '';
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

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        curl_setopt($this->handle, CURLOPT_URL, (string) $request->getUri());
        curl_setopt($this->handle, CURLOPT_HEADERFUNCTION, [$this, 'headerFunction']);

        $ret = curl_exec($this->handle);

        if ($errno = curl_errno($this->handle)) {
            throw new ClientException(curl_error($this->handle), $errno);
        }

        $this->parseHeaders($this->responseHeader);

        $response = new Response($ret, $this->statusCode, $this->responseHeaders);
        return $response;
    }

    public function get($uri, $headers = []): ResponseInterface
    {
        $request = new Request('GET', $uri, $headers);
        print_r($request);
        return $this->sendRequest($request);
    }
}
