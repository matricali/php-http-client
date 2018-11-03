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

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractMessage implements MessageInterface
{
    protected $protocolVersion;
    protected $headers;
    protected $body;

    /**
     * AbstractMessage constructor.
     *
     * @param string $protocolVersion
     * @param array  $headers         header value(s)
     * @param string $body
     *
     * @throws \InvalidArgumentException for invalid HTTP methods
     */
    public function __construct($protocolVersion = '1.1', array $headers = [], $body = null)
    {
        if (null !== $body && !is_string($body)) {
            throw new \InvalidArgumentException('The body parameter must be of the string type');
        }
        $this->protocolVersion = $protocolVersion;
        $this->headers = [];
        if (null !== $headers) {
            foreach ($headers as $k => $v) {
                if (!is_array($v)) {
                    $this->headers[$k] = array_map('trim', explode(',', $v));
                    continue;
                }
                $this->headers[$k] = $v;
            }
        }
        $this->body = $body;
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     *
     * @return static
     */
    public function withProtocolVersion($version)
    {
        $clone = clone $this;
        $clone->protocolVersion = $version;

        return $clone;
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ": " . implode(", ", $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return string[][] Returns an associative array of the message's headers. Each
     *                    key MUST be a header name, and each value MUST be an array of strings
     *                    for that header.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name case-insensitive header field name
     *
     * @return bool Returns true if any header names match the given header
     *              name using a case-insensitive string comparison. Returns false if
     *              no matching header name is found in the message.
     */
    public function hasHeader($name)
    {
        return false !== $this->searchHeader($name);
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name case-insensitive header field name
     *
     * @return string[] An array of string values as provided for the given
     *                  header. If the header does not appear in the message, this method MUST
     *                  return an empty array.
     */
    public function getHeader($name)
    {
        $key = $this->searchHeader($name);
        if (false !== $key) {
            return $this->headers[$key];
        }

        return [];
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * This method returns all of the header values of the given
     * case-insensitive header name as a string concatenated together using
     * a comma.
     *
     * NOTE: Not all header values may be appropriately represented using
     * comma concatenation. For such headers, use getHeader() instead
     * and supply your own delimiter when concatenating.
     *
     * If the header does not appear in the message, this method MUST return
     * an empty string.
     *
     * @param string $name case-insensitive header field name
     *
     * @return string A string of values as provided for the given header
     *                concatenated together using a comma. If the header does not appear in
     *                the message, this method MUST return an empty string.
     */
    public function getHeaderLine($name)
    {
        $key = $this->searchHeader($name);
        if (false !== $key) {
            return implode(', ', $this->headers[$key]);
        }

        return '';
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string          $name  case-insensitive header field name
     * @param string|string[] $value header value(s)
     *
     * @throws \InvalidArgumentException for invalid header names or values
     *
     * @return static
     */
    public function withHeader($name, $value)
    {
        $key = $this->searchHeader($name);
        $value = is_array($value) ? $value : [$value];
        if (false !== $key) {
            $name = $key;
        }
        $clone = clone $this;
        $clone->headers[$name] = $value;

        return $clone;
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string          $name  case-insensitive header field name to add
     * @param string|string[] $value header value(s)
     *
     * @throws \InvalidArgumentException for invalid header names or values
     *
     * @return static
     */
    public function withAddedHeader($name, $value)
    {
        $key = $this->searchHeader($name);
        $value = is_array($value) ? $value : [$value];
        if (false !== $key) {
            $name = $key;
            $value = array_merge($this->headers[$key], $value);
        }
        $clone = clone $this;
        $clone->headers[$name] = $value;

        return $clone;
    }

    /**
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name case-insensitive header field name to remove
     *
     * @return static
     */
    public function withoutHeader($name)
    {
        $clone = clone $this;
        $key = $this->searchHeader($name);
        if (false !== $key) {
            unset($clone->headers[$key]);
        }

        return $clone;
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface returns the body as a stream
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param StreamInterface $body body
     *
     * @throws \InvalidArgumentException when the body is not valid
     *
     * @return static
     */
    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->body = $body->__toString();

        return $clone;
    }

    /**
     * Retrieves the index if a header exists by the given case-insensitive name.
     *
     * @param string $name case-insensitive header field name
     *
     * @return mixed Returns integer if any header names match the given header
     *               name using a case-insensitive string comparison. Returns false if
     *               no matching header name is found in the message.
     */
    protected function searchHeader($name)
    {
        $keysHeader = array_keys($this->headers);
        $index = array_search(strtolower($name), array_map('strtolower', $keysHeader));

        return false !== $index ? $keysHeader[$index] : $index;
    }
}
