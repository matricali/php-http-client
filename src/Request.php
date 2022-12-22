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
use Psr\Http\Message\UriInterface;

class Request extends AbstractMessage implements RequestInterface
{
    protected $method;
    protected $uri;

    /**
     * Request constructor.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * @param string $method  case-sensitive method
     * @param string $uri     Resource URI.-
     * @param array  $headers header value(s)
     * @param string $body    Body to send in the request.-
     *
     * @throws \InvalidArgumentException for invalid HTTP methods
     */
    public function __construct(
        $method,
        $uri = '',
        array $headers = [],
        $body = null
    ) {
        $this->validateMethod($method);
        parent::__construct('1.1', $headers, $body);
        $this->method = $method;

        if (is_string($uri)) {
            $this->uri = new Uri($uri);
        }
    }

    /**
     * __clone.
     *
     * @return Request
     */
    public function __clone()
    {
        return new self($this->method);
    }

    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget()
    {
        $uri = (string) $this->uri;
        if (empty($uri)) {
            return '/';
        }

        return $uri;
    }

    /**
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @see http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     *
     * @param mixed $requestTarget
     *
     * @return static
     */
    public function withRequestTarget($requestTarget)
    {
        $clone = clone $this;

        return $clone;
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string returns the request method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param string $method case-sensitive method
     *
     * @throws \InvalidArgumentException for invalid HTTP methods
     *
     * @return static
     */
    public function withMethod($method)
    {
        $this->validateMethod($method);
        $clone = clone $this;
        $clone->method = $method;

        return $clone;
    }

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @return UriInterface returns a UriInterface instance
     *                      representing the URI of the request
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     *
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the returned
     *   request.
     * - If the Host header is missing or empty, and the new URI does not contain a
     *   host component, this method MUST NOT update the Host header in the returned
     *   request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @param UriInterface $uri          new request URI to use
     * @param bool         $preserveHost preserve the original state of the Host header
     *
     * @return static
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $clone = clone $this;
        $clone->uri = $uri;

        return $clone;
    }

    /**
     * Validate HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * @param string $method case-sensitive method
     *
     * @throws \InvalidArgumentException for invalid HTTP methods
     */
    protected function validateMethod($method)
    {
        if (!HttpMethod::isValidValue($method)) {
            throw new \InvalidArgumentException(sprintf('The HTTP method "%s" is not valid.', $method));
        }
    }
}
