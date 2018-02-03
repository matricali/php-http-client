<?php

namespace Matricali\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    protected $handle = null;

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if ($this->handle === null) {
            $this->handle = curl_init();
        }

        $ret = curl_exec($this->handle);
    }

    public function get($uri, $headers = []): ResponseInterface
    {
        $request = new Request('GET', $uri, $headers);
        return $this->sendRequest($request);
    }
}
