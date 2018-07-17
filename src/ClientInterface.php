<?php

namespace Matricali\Http;

interface ClientInterface
{
    /**
     * Set the options
     *
     * @param array  $options Options to apply to the request.-
     */
    public function setOptions(array $options);

    /**
     * Create a GET request for the client
     *
     * @param string $uri Resource URI.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     */
    public function get($uri, array $headers = array(), array $options = array());

    /**
     * Create a POST request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     */
    public function post($uri, $body = '', array $headers = array(), array $options = array());

    /**
     * Create a HEAD request for the client
     *
     * @param string $uri Resource URI.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     */
    public function head($uri, array $headers = array(), array $options = array());

    /**
     * Create a DELETE request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     */
    public function delete($uri, $body = '', array $headers = array(), array $options = array());

    /**
     * Create a PUT request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     */
    public function put($uri, $body = '', array $headers = array(), array $options = array());

    /**
     * Create a PATCH request for the client
     *
     * @param string $uri Resource URI.-
     * @param string $body Body to send in the request.-
     * @param array $headers HTTP headers.-
     * @param array $options Options to apply to the request.-
     * @return Response
     */
    public function patch($uri, $body = '', array $headers = array(), array $options = array());
}
