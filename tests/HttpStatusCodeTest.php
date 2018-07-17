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

use PHPUnit\Framework\TestCase;

/**
 * @author Gabriel Polverini <gpolverini_ext@amco.mx>
 *
 * @group Enums
 */
class HttpStatusCodeTest extends TestCase
{
    const NAME_HTTP_CONTINUE = 'HTTP_CONTINUE';
    const NAME_HTTP_SWITCHING_PROTOCOLS = 'HTTP_SWITCHING_PROTOCOLS';
    const NAME_HTTP_PROCESSING = 'HTTP_PROCESSING';
    const NAME_HTTP_EARLY_HINTS = 'HTTP_EARLY_HINTS';
    const NAME_HTTP_OK = 'HTTP_OK';
    const NAME_HTTP_CREATED = 'HTTP_CREATED';
    const NAME_HTTP_ACCEPTED = 'HTTP_ACCEPTED';
    const NAME_HTTP_NON_AUTHORITATIVE_INFORMATION = 'HTTP_NON_AUTHORITATIVE_INFORMATION';
    const NAME_HTTP_NO_CONTENT = 'HTTP_NO_CONTENT';
    const NAME_HTTP_RESET_CONTENT = 'HTTP_RESET_CONTENT';
    const NAME_HTTP_PARTIAL_CONTENT = 'HTTP_PARTIAL_CONTENT';
    const NAME_HTTP_MULTI_STATUS = 'HTTP_MULTI_STATUS';
    const NAME_HTTP_ALREADY_REPORTED = 'HTTP_ALREADY_REPORTED';
    const NAME_HTTP_IM_USED = 'HTTP_IM_USED';
    const NAME_HTTP_MULTIPLE_CHOICES = 'HTTP_MULTIPLE_CHOICES';
    const NAME_HTTP_MOVED_PERMANENTLY = 'HTTP_MOVED_PERMANENTLY';
    const NAME_HTTP_FOUND = 'HTTP_FOUND';
    const NAME_HTTP_SEE_OTHER = 'HTTP_SEE_OTHER';
    const NAME_HTTP_NOT_MODIFIED = 'HTTP_NOT_MODIFIED';
    const NAME_HTTP_USE_PROXY = 'HTTP_USE_PROXY';
    const NAME_HTTP_RESERVED = 'HTTP_RESERVED';
    const NAME_HTTP_TEMPORARY_REDIRECT = 'HTTP_TEMPORARY_REDIRECT';
    const NAME_HTTP_PERMANENTLY_REDIRECT = 'HTTP_PERMANENTLY_REDIRECT';
    const NAME_HTTP_BAD_REQUEST = 'HTTP_BAD_REQUEST';
    const NAME_HTTP_UNAUTHORIZED = 'HTTP_UNAUTHORIZED';
    const NAME_HTTP_PAYMENT_REQUIRED = 'HTTP_PAYMENT_REQUIRED';
    const NAME_HTTP_FORBIDDEN = 'HTTP_FORBIDDEN';
    const NAME_HTTP_NOT_FOUND = 'HTTP_NOT_FOUND';
    const NAME_HTTP_METHOD_NOT_ALLOWED = 'HTTP_METHOD_NOT_ALLOWED';
    const NAME_HTTP_NOT_ACCEPTABLE = 'HTTP_NOT_ACCEPTABLE';
    const NAME_HTTP_PROXY_AUTHENTICATION_REQUIRED = 'HTTP_PROXY_AUTHENTICATION_REQUIRED';
    const NAME_HTTP_REQUEST_TIMEOUT = 'HTTP_REQUEST_TIMEOUT';
    const NAME_HTTP_CONFLICT = 'HTTP_CONFLICT';
    const NAME_HTTP_GONE = 'HTTP_GONE';
    const NAME_HTTP_LENGTH_REQUIRED = 'HTTP_LENGTH_REQUIRED';
    const NAME_HTTP_PRECONDITION_FAILED = 'HTTP_PRECONDITION_FAILED';
    const NAME_HTTP_REQUEST_ENTITY_TOO_LARGE = 'HTTP_REQUEST_ENTITY_TOO_LARGE';
    const NAME_HTTP_REQUEST_URI_TOO_LONG = 'HTTP_REQUEST_URI_TOO_LONG';
    const NAME_HTTP_UNSUPPORTED_MEDIA_TYPE = 'HTTP_UNSUPPORTED_MEDIA_TYPE';
    const NAME_HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 'HTTP_REQUESTED_RANGE_NOT_SATISFIABLE';
    const NAME_HTTP_EXPECTATION_FAILED = 'HTTP_EXPECTATION_FAILED';
    const NAME_HTTP_I_AM_A_TEAPOT = 'HTTP_I_AM_A_TEAPOT';
    const NAME_HTTP_MISDIRECTED_REQUEST = 'HTTP_MISDIRECTED_REQUEST';
    const NAME_HTTP_UNPROCESSABLE_ENTITY = 'HTTP_UNPROCESSABLE_ENTITY';
    const NAME_HTTP_LOCKED = 'HTTP_LOCKED';
    const NAME_HTTP_FAILED_DEPENDENCY = 'HTTP_FAILED_DEPENDENCY';
    const NAME_HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 'HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL';
    const NAME_HTTP_TOO_EARLY = 'HTTP_TOO_EARLY';
    const NAME_HTTP_UPGRADE_REQUIRED = 'HTTP_UPGRADE_REQUIRED';
    const NAME_HTTP_PRECONDITION_REQUIRED = 'HTTP_PRECONDITION_REQUIRED';
    const NAME_HTTP_TOO_MANY_REQUESTS = 'HTTP_TOO_MANY_REQUESTS';
    const NAME_HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 'HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE';
    const NAME_HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 'HTTP_UNAVAILABLE_FOR_LEGAL_REASONS';
    const NAME_HTTP_INTERNAL_SERVER_ERROR = 'HTTP_INTERNAL_SERVER_ERROR';
    const NAME_HTTP_NOT_IMPLEMENTED = 'HTTP_NOT_IMPLEMENTED';
    const NAME_HTTP_BAD_GATEWAY = 'HTTP_BAD_GATEWAY';
    const NAME_HTTP_SERVICE_UNAVAILABLE = 'HTTP_SERVICE_UNAVAILABLE';
    const NAME_HTTP_GATEWAY_TIMEOUT = 'HTTP_GATEWAY_TIMEOUT';
    const NAME_HTTP_VERSION_NOT_SUPPORTED = 'HTTP_VERSION_NOT_SUPPORTED';
    const NAME_HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 'HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL';
    const NAME_HTTP_INSUFFICIENT_STORAGE = 'HTTP_INSUFFICIENT_STORAGE';
    const NAME_HTTP_LOOP_DETECTED = 'HTTP_LOOP_DETECTED';
    const NAME_HTTP_NOT_EXTENDED = 'HTTP_NOT_EXTENDED';
    const NAME_HTTP_NETWORK_AUTHENTICATION_REQUIRED = 'HTTP_NETWORK_AUTHENTICATION_REQUIRED';
    const NAME_NOTEXIST = '';

    protected $httpStatusCode;

    public function setUp()
    {
        $this->httpStatusCode = $this->getMockForAbstractClass('Matricali\Http\HttpStatusCode');
    }

    /**
     * @test
     */
    public function testIsValidNameHttpContinue()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_CONTINUE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpContinue()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_CONTINUE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpContinue
     *
     * @param string $value
     */
    public function testIsValidValueHttpContinue($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpSwitchingProtocols()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_SWITCHING_PROTOCOLS));
    }

    /**
     * @test
     */
    public function testGetByNameHttpSwitchingProtocols()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_SWITCHING_PROTOCOLS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpSwitchingProtocols
     *
     * @param string $value
     */
    public function testIsValidValueHttpSwitchingProtocols($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpProcessing()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PROCESSING));
    }

    /**
     * @test
     */
    public function testGetByNameHttpProcessing()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PROCESSING);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpProcessing
     *
     * @param string $value
     */
    public function testIsValidValueHttpProcessing($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpEarlyHints()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_EARLY_HINTS));
    }

    /**
     * @test
     */
    public function testGetByNameHttpEarlyHints()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_EARLY_HINTS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpEarlyHints
     *
     * @param string $value
     */
    public function testIsValidValueHttpEarlyHints($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpOk()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_OK));
    }

    /**
     * @test
     */
    public function testGetByNameHttpOk()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_OK);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpOk
     *
     * @param string $value
     */
    public function testIsValidValueHttpOk($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpCreated()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_CREATED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpCreated()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_CREATED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpCreated
     *
     * @param string $value
     */
    public function testIsValidValueHttpCreated($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpAccepted()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_ACCEPTED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpAccepted()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_ACCEPTED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpAccepted
     *
     * @param string $value
     */
    public function testIsValidValueHttpAccepted($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNonAuthoritativeInformation()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NON_AUTHORITATIVE_INFORMATION));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNonAuthoritativeInformation()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NON_AUTHORITATIVE_INFORMATION);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNonAuthoritativeInformation
     *
     * @param string $value
     */
    public function testIsValidValueHttpNonAuthoritativeInformation($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNoContent()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NO_CONTENT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNoContent()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NO_CONTENT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNoContent
     *
     * @param string $value
     */
    public function testIsValidValueHttpNoContent($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpResetContent()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_RESET_CONTENT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpResetContent()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_RESET_CONTENT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpResetContent
     *
     * @param string $value
     */
    public function testIsValidValueHttpResetContent($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttPartialContent()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PARTIAL_CONTENT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpPartialContent()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PARTIAL_CONTENT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpPartialContent
     *
     * @param string $value
     */
    public function testIsValidValueHttpPartialContent($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpMultiStatus()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_MULTI_STATUS));
    }

    /**
     * @test
     */
    public function testGetByNameHttpMultiStatus()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_MULTI_STATUS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpMultiStatus
     *
     * @param string $value
     */
    public function testIsValidValueHttpMultiStatus($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpAlreadyReported()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_ALREADY_REPORTED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpAlreadyReported()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_ALREADY_REPORTED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpAlreadyReported
     *
     * @param string $value
     */
    public function testIsValidValueHttpAlreadyReported($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpImUsed()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_IM_USED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpImUsed()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_IM_USED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpImUsed
     *
     * @param string $value
     */
    public function testIsValidValueHttpImUsed($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpMultipleChoices()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_MULTIPLE_CHOICES));
    }

    /**
     * @test
     */
    public function testGetByNameHttpMultipleChoices()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_MULTIPLE_CHOICES);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpMultipleChoices
     *
     * @param string $value
     */
    public function testIsValidValueHttpMultipleChoices($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpMovedPermanently()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_MOVED_PERMANENTLY));
    }

    /**
     * @test
     */
    public function testGetByNameHttpMovedPermanently()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_MOVED_PERMANENTLY);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpMovedPermanently
     *
     * @param string $value
     */
    public function testIsValidValueHttpMovedPermanently($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpFound()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_FOUND));
    }

    /**
     * @test
     */
    public function testGetByNameHttpFound()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_FOUND);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpFound
     *
     * @param string $value
     */
    public function testIsValidValueHttpFound($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpSeeOther()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_SEE_OTHER));
    }

    /**
     * @test
     */
    public function testGetByNameHttpSeeOther()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_SEE_OTHER);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpSeeOther
     *
     * @param string $value
     */
    public function testIsValidValueHttpSeeOther($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNotModified()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NOT_MODIFIED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNotModified()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NOT_MODIFIED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNotModified
     *
     * @param string $value
     */
    public function testIsValidValueHttpNotModified($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpUseProxy()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_USE_PROXY));
    }

    /**
     * @test
     */
    public function testGetByNameHttpUseProxy()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_USE_PROXY);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpUseProxy
     *
     * @param string $value
     */
    public function testIsValidValueHttpUseProxy($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpReserved()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_RESERVED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpReserved()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_RESERVED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpReserved
     *
     * @param string $value
     */
    public function testIsValidValueHttpReserved($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpTemporaryRedirect()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_TEMPORARY_REDIRECT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpTemporaryRedirect()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_TEMPORARY_REDIRECT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpTemporaryRedirect
     *
     * @param string $value
     */
    public function testIsValidValueHttpTemporaryRedirect($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpPermanentlyRedirect()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PERMANENTLY_REDIRECT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpPermanentlyRedirect()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PERMANENTLY_REDIRECT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpPermanentlyRedirect
     *
     * @param string $value
     */
    public function testIsValidValueHttpPermanentlyRedirect($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpBadRequest()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_BAD_REQUEST));
    }

    /**
     * @test
     */
    public function testGetByNameHttpBadRequest()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_BAD_REQUEST);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpBadRequest
     *
     * @param string $value
     */
    public function testIsValidValueHttpBadRequest($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpUnauthorized()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_UNAUTHORIZED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpUnauthorized()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_UNAUTHORIZED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpUnauthorized
     *
     * @param string $value
     */
    public function testIsValidValueHttpUnauthorized($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpPaymentRequired()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PAYMENT_REQUIRED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpPaymentRequired()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PAYMENT_REQUIRED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpPaymentRequired
     *
     * @param string $value
     */
    public function testIsValidValueHttpPaymentRequired($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpForbidden()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_FORBIDDEN));
    }

    /**
     * @test
     */
    public function testGetByNameHttpForbidden()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_FORBIDDEN);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpForbidden
     *
     * @param string $value
     */
    public function testIsValidValueHttpForbidden($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNotFound()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NOT_FOUND));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNotFound()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NOT_FOUND);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNotFound
     *
     * @param string $value
     */
    public function testIsValidValueHttpNotFound($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpMethodNotAllowed()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_METHOD_NOT_ALLOWED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpMethodNotAllowed()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_METHOD_NOT_ALLOWED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpMethodNotAllowed
     *
     * @param string $value
     */
    public function testIsValidValueHttpMethodNotAllowed($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNotAcceptable()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NOT_ACCEPTABLE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNotAcceptable()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NOT_ACCEPTABLE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNotAcceptable
     *
     * @param string $value
     */
    public function testIsValidValueHttpNotAcceptable($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpProxyAuthenticationRequired()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PROXY_AUTHENTICATION_REQUIRED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpProxyAuthenticationRequired()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PROXY_AUTHENTICATION_REQUIRED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpProxyAuthenticationRequired
     *
     * @param string $value
     */
    public function testIsValidValueHttpProxyAuthenticationRequired($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpRequestTimeout()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_REQUEST_TIMEOUT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpRequestTimeout()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_REQUEST_TIMEOUT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpRequestTimeout
     *
     * @param string $value
     */
    public function testIsValidValueHttpRequestTimeout($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpConflict()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_CONFLICT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpConflict()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_CONFLICT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpConflict
     *
     * @param string $value
     */
    public function testIsValidValueHttpConflict($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpGone()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_GONE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpGone()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_GONE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpGone
     *
     * @param string $value
     */
    public function testIsValidValueHttpGone($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpLengthRequired()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_LENGTH_REQUIRED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpLengthRequired()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_LENGTH_REQUIRED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpLengthRequired
     *
     * @param string $value
     */
    public function testIsValidValueHttpLengthRequired($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpPreconditionFailed()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PRECONDITION_FAILED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpPreconditionFailed()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PRECONDITION_FAILED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpPreconditionFailed
     *
     * @param string $value
     */
    public function testIsValidValueHttpPreconditionFailed($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpRequestEntityTooLarge()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_REQUEST_ENTITY_TOO_LARGE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpRequestEntityTooLarge()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_REQUEST_ENTITY_TOO_LARGE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpRequestEntityTooLarge
     *
     * @param string $value
     */
    public function testIsValidValueHttpRequestEntityTooLarge($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpRequestUriTooLong()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_REQUEST_URI_TOO_LONG));
    }

    /**
     * @test
     */
    public function testGetByNameHttpRequestUriTooLong()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_REQUEST_URI_TOO_LONG);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpRequestUriTooLong
     *
     * @param string $value
     */
    public function testIsValidValueHttpRequestUriTooLong($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpUnsupportedMediaType()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_UNSUPPORTED_MEDIA_TYPE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpUnsupportedMediaType()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_UNSUPPORTED_MEDIA_TYPE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpUnsupportedMediaType
     *
     * @param string $value
     */
    public function testIsValidValueHttpUnsupportedMediaType($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpRequestedRangeNotSatistiable()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_REQUESTED_RANGE_NOT_SATISFIABLE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpRequestedRangeNotSatistiable()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_REQUESTED_RANGE_NOT_SATISFIABLE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpRequestedRangeNotSatistiable
     *
     * @param string $value
     */
    public function testIsValidValueHttpRequestedRangeNotSatistiable($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpExpectationFailed()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_EXPECTATION_FAILED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpExpectationFailed()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_EXPECTATION_FAILED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpExpectationFailed
     *
     * @param string $value
     */
    public function testIsValidValueHttpExpectationFailed($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpIAmATeapot()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_I_AM_A_TEAPOT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpIAmATeapot()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_I_AM_A_TEAPOT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpIAmATeapot
     *
     * @param string $value
     */
    public function testIsValidValueHttpIAmATeapot($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpMisdirectedRequest()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_MISDIRECTED_REQUEST));
    }

    /**
     * @test
     */
    public function testGetByNameHttpMisdirectedRequest()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_MISDIRECTED_REQUEST);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpMisdirectedRequest
     *
     * @param string $value
     */
    public function testIsValidValueHttpMisdirectedRequest($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpUnprocessableEntity()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * @test
     */
    public function testGetByNameHttpUnprocessableEntity()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpUnprocessableEntity
     *
     * @param string $value
     */
    public function testIsValidValueHttpUnprocessableEntity($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpLocked()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_LOCKED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpLocked()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_LOCKED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpLocked
     *
     * @param string $value
     */
    public function testIsValidValueHttpLocked($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpFailedDependency()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_FAILED_DEPENDENCY));
    }

    /**
     * @test
     */
    public function testGetByNameHttpFailedDependency()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_FAILED_DEPENDENCY);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpFailedDependency
     *
     * @param string $value
     */
    public function testIsValidValueHttpFailedDependency($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpReservedForWebdavAdvancedCollectionsExpiredProposal()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL));
    }

    /**
     * @test
     */
    public function testGetByNameHttpReservedForWebdavAdvancedCollectionsExpiredProposal()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpReservedForWebdavAdvancedCollectionsExpiredProposal
     *
     * @param string $value
     */
    public function testIsValidValueHttpReservedForWebdavAdvancedCollectionsExpiredProposal($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpTooEarly()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_TOO_EARLY));
    }

    /**
     * @test
     */
    public function testGetByNameHttpTooEarly()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_TOO_EARLY);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpTooEarly
     *
     * @param string $value
     */
    public function testIsValidValueHttpTooEarly($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpUpgradeRequired()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_UPGRADE_REQUIRED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpUpgradeRequired()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_UPGRADE_REQUIRED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpUpgradeRequired
     *
     * @param string $value
     */
    public function testIsValidValueHttpUpgradeRequired($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpPreconditionRequired()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_PRECONDITION_REQUIRED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpPreconditionRequired()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_PRECONDITION_REQUIRED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpPreconditionRequired
     *
     * @param string $value
     */
    public function testIsValidValueHttpPreconditionRequired($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpTooManyRequests()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_TOO_MANY_REQUESTS));
    }

    /**
     * @test
     */
    public function testGetByNameHttpTooManyRequests()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_TOO_MANY_REQUESTS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpTooManyRequests
     *
     * @param string $value
     */
    public function testIsValidValueHttpTooManyRequests($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpRequestHeaderFieldsTooLarge()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpRequestHeaderFieldsTooLarge()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpRequestHeaderFieldsTooLarge
     *
     * @param string $value
     */
    public function testIsValidValueHttpRequestHeaderFieldsTooLarge($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpUnavailableForLegalReasons()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_UNAVAILABLE_FOR_LEGAL_REASONS));
    }

    /**
     * @test
     */
    public function testGetByNameHttpUnavailableForLegalReasons()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpUnavailableForLegalReasons
     *
     * @param string $value
     */
    public function testIsValidValueHttpUnavailableForLegalReasons($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpInternalServerError()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_INTERNAL_SERVER_ERROR));
    }

    /**
     * @test
     */
    public function testGetByNameHttpInternalServerError()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_INTERNAL_SERVER_ERROR);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpInternalServerError
     *
     * @param string $value
     */
    public function testIsValidValueHttpInternalServerError($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNotImplemented()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NOT_IMPLEMENTED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNotImplemented()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NOT_IMPLEMENTED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNotImplemented
     *
     * @param string $value
     */
    public function testIsValidValueHttpNotImplemented($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpBadGateway()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_BAD_GATEWAY));
    }

    /**
     * @test
     */
    public function testGetByNameHttpBadGateway()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_BAD_GATEWAY);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpBadGateway
     *
     * @param string $value
     */
    public function testIsValidValueHttpBadGateway($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpServiceUnavailable()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_SERVICE_UNAVAILABLE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpServiceUnavailable()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_SERVICE_UNAVAILABLE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpServiceUnavailable
     *
     * @param string $value
     */
    public function testIsValidValueHttpServiceUnavailable($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpGatewayTimeout()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_GATEWAY_TIMEOUT));
    }

    /**
     * @test
     */
    public function testGetByNameHttpGatewayTimeout()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_GATEWAY_TIMEOUT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpGatewayTimeout
     *
     * @param string $value
     */
    public function testIsValidValueHttpGatewayTimeout($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpVersionNotSupported()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_VERSION_NOT_SUPPORTED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpVersionNotSupported()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_VERSION_NOT_SUPPORTED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpVersionNotSupported
     *
     * @param string $value
     */
    public function testIsValidValueHttpVersionNotSupported($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpVariantAlsoNegotiatesExperimental()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL));
    }

    /**
     * @test
     */
    public function testGetByNameHttpVariantAlsoNegotiatesExperimental()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpVariantAlsoNegotiatesExperimental
     *
     * @param string $value
     */
    public function testIsValidValueHttpVariantAlsoNegotiatesExperimental($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpInsufficientStorage()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_INSUFFICIENT_STORAGE));
    }

    /**
     * @test
     */
    public function testGetByNameHttpInsufficientStorage()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_INSUFFICIENT_STORAGE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpInsufficientStorage
     *
     * @param string $value
     */
    public function testIsValidValueHttpInsufficientStorage($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpLoopDetected()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_LOOP_DETECTED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpLoopDetected()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_LOOP_DETECTED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpLoopDetected
     *
     * @param string $value
     */
    public function testIsValidValueHttpLoopDetected($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttpNotExtended()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NOT_EXTENDED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNotExtended()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NOT_EXTENDED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNotExtended
     *
     * @param string $value
     */
    public function testIsValidValueHttpNotExtended($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }


    /**
     * @test
     */
    public function testIsValidNameHttpNetworkAuthenticationRequired()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_NETWORK_AUTHENTICATION_REQUIRED));
    }

    /**
     * @test
     */
    public function testGetByNameHttpNetworkAuthenticationRequired()
    {
        $value = $this->httpStatusCode->getByName(self::NAME_HTTP_NETWORK_AUTHENTICATION_REQUIRED);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttpNetworkAuthenticationRequired
     *
     * @param string $value
     */
    public function testIsValidValueHttpNetworkAuthenticationRequired($value)
    {
        $this->assertTrue($this->httpStatusCode->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameStrictTrue()
    {
        $this->assertTrue($this->httpStatusCode->isValidName(self::NAME_HTTP_CONTINUE, true));
    }

    /**
     * @test
     */
    public function testGetByNameNotExist()
    {
        $this->assertNull($this->httpStatusCode->getByName(self::NAME_NOTEXIST));
    }
}