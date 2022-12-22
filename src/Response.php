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

use Psr\Http\Message\ResponseInterface;

/**
 * Representation of an outgoing, server-side response.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - Status code and reason phrase
 * - Headers
 * - Message body
 *
 * Responses are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state.
 */
class Response extends AbstractMessage implements ResponseInterface
{
    protected $statusCode;
    protected $reasonPhrase;

    /**
     * Response constructor.
     *
     * @param string $body            Body to return in the response.-
     * @param int    $statusCode
     * @param array  $headers         header value(s)
     * @param string $protocolVersion HTTP protocol version
     *
     * @throws \InvalidArgumentException for invalid HTTP methods
     */
    public function __construct(
        $body = '',
        $statusCode = HttpStatusCode::HTTP_OK,
        array $headers = [],
        $protocolVersion = '1.1'
    ) {
        $this->validateStatusCode($statusCode);
        parent::__construct($protocolVersion, $headers, $body);
        $this->statusCode = $statusCode;
        $this->reasonPhrase = '';
    }

    /**
     * __clone.
     *
     * @return Response
     */
    public function __clone()
    {
        return new self();
    }

    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     *
     * @param int    $code         the 3-digit integer result code to set
     * @param string $reasonPhrase the reason phrase to use with the
     *                             provided status code; if none is provided, implementations MAY
     *                             use the defaults as suggested in the HTTP specification
     *
     * @throws \InvalidArgumentException for invalid status code arguments
     *
     * @return static
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $this->validateStatusCode($code);

        $clone = clone $this;
        $clone->statusCode = $code;
        $clone->reasonPhrase = 'unknown status';
        if (!empty($reasonPhrase)) {
            $clone->reasonPhrase = $reasonPhrase;
        } elseif (isset(HttpStatusCode::$statusTexts[$code])) {
            $clone->reasonPhrase = HttpStatusCode::$statusTexts[$code];
        }

        return $clone;
    }

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * Because a reason phrase is not a required element in a response
     * status line, the reason phrase value MAY be null. Implementations MAY
     * choose to return the default RFC 7231 recommended reason phrase (or those
     * listed in the IANA HTTP Status Code Registry) for the response's
     * status code.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     *
     * @return string reason phrase; must return an empty string if none present
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * Validate the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @param int $statusCode
     *
     * @throws \InvalidArgumentException for invalid HTTP methods
     */
    protected function validateStatusCode($statusCode)
    {
        if (!HttpStatusCode::isValidValue($statusCode)) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $statusCode));
        }
    }
}
