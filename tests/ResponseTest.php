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

namespace Matricali\Http\Tests;

use Matricali\Http\HttpStatusCode;
use Matricali\Http\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group Response
 */
class ResponseTest extends TestCase
{
    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInstanceInvalidStatusCodeParam()
    {
        new Response('', -1);
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInstanceInvalidBodyParam()
    {
        new Response(1);
    }

    /**
     * @test
     */
    public function testSearchHeader()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $response = new Response('', 200, $headers);

        $reflection = new \ReflectionClass($response);
        $method = $reflection->getMethod('searchHeader');
        $method->setAccessible(true);
        $this->assertFalse($method->invoke($response, 'Content-Encoding'));
        $this->assertFalse($method->invoke($response, 'content-encoding'));
        $expected = 'Accept';
        $this->assertEquals($expected, $method->invoke($response, 'Accept'));
        $this->assertEquals($expected, $method->invoke($response, 'accept'));
        $expected = 'Content-Type';
        $this->assertEquals($expected, $method->invoke($response, 'Content-Type'));
        $this->assertEquals($expected, $method->invoke($response, 'content-type'));
    }

    /**
     * @test
     */
    public function testGetProtocolVersion()
    {
        $response = new Response('');
        $this->assertEquals('1.1', $response->getProtocolVersion());
        $protocolVersion = '1.0';
        $this->assertEquals($protocolVersion, $response->withProtocolVersion($protocolVersion)->getProtocolVersion());
    }

    /**
     * @test
     */
    public function testWithProtocolVersion()
    {
        $response = new Response('');
        $protocolVersion = $response->getProtocolVersion();
        $this->assertEquals($protocolVersion, $response->withProtocolVersion('1.1')->getProtocolVersion());
        $this->assertNotEquals($protocolVersion, $response->withProtocolVersion('1.0')->getProtocolVersion());
    }

    /**
     * @test
     */
    public function testGetHeaders()
    {
        $body = '';
        $this->assertTrue(is_array((new Response($body))->getHeaders()));

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $expected = [
            'Accept' => ['application/json'],
            'Content-Type' => ['text/xml;charset=UTF-8'],
        ];
        $this->assertEquals($expected, (new Response($body, 200, $headers))->getHeaders());
    }

    /**
     * @test
     */
    public function testHasHeader()
    {
        $body = '';
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $response = new Response($body, 200, $headers);
        $this->assertFalse($response->hasHeader('Content-Encoding'));
        $this->assertFalse($response->hasHeader('content-encoding'));
        $this->assertTrue($response->hasHeader('Accept'));
        $this->assertTrue($response->hasHeader('accept'));
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertTrue($response->hasHeader('content-type'));
    }

    /**
     * @test
     */
    public function testGetHeader()
    {
        $body = '';
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $response = new Response($body, 200, $headers);
        $expected = [];
        $this->assertEquals($expected, $response->getHeader('Content-Encoding'));
        $this->assertEquals($expected, $response->getHeader('content-encoding'));
        $expected = ['application/json'];
        $this->assertEquals($expected, $response->getHeader('Accept'));
        $this->assertEquals($expected, $response->getHeader('accept'));
    }

    /**
     * @test
     */
    public function testGetHeaderLine()
    {
        $body = '';
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
            'Cache-Control' => [
                'no-transform',
                'public',
                'max-age=2678400',
                's-maxage=2678400',
            ],
        ];
        $response = new Response($body, 200, $headers);
        $expected = '';
        $this->assertEquals($expected, $response->getHeaderLine('Content-Encoding'));
        $this->assertEquals($expected, $response->getHeaderLine('content-encoding'));
        $expected = 'application/json';
        $this->assertEquals($expected, $response->getHeaderLine('Accept'));
        $this->assertEquals($expected, $response->getHeaderLine('accept'));
        $expected = 'text/xml;charset=UTF-8';
        $this->assertEquals($expected, $response->getHeaderLine('Content-Type'));
        $this->assertEquals($expected, $response->getHeaderLine('content-type'));
        $expected = implode(', ', $headers['Cache-Control']);
        $this->assertEquals($expected, $response->getHeaderLine('Cache-Control'));
        $this->assertEquals($expected, $response->getHeaderLine('cache-control'));
    }

    /**
     * @test
     */
    public function testWithHeader()
    {
        $body = '';
        $headers = ['Accept' => ['application/json']];
        $response = new Response($body, 200, $headers);
        $expected = array_merge($headers, ['Content-Encoding' => ['gzip']]);
        $this->assertEquals($expected, $response->withHeader('Content-Encoding', 'gzip')->getHeaders());
        $this->assertEquals($expected, $response->withHeader('Content-Encoding', ['gzip'])->getHeaders());
        $expected = ['Accept' => ['application/xml']];
        $this->assertEquals($expected, $response->withHeader('Accept', 'application/xml')->getHeaders());
        $this->assertEquals($expected, $response->withHeader('Accept', ['application/xml'])->getHeaders());
    }

    /**
     * @test
     */
    public function testWithAddedHeader()
    {
        $body = '';
        $headers = ['Accept' => ['application/json']];
        $response = new Response($body, 200, $headers);
        $expected = array_merge($headers, ['Content-Encoding' => ['gzip']]);
        $this->assertEquals($expected, $response->withAddedHeader('Content-Encoding', 'gzip')->getHeaders());
        $this->assertEquals($expected, $response->withAddedHeader('Content-Encoding', ['gzip'])->getHeaders());
        $expected = ['Accept' => ['application/json', 'application/xml']];
        $this->assertEquals($expected, $response->withAddedHeader('Accept', 'application/xml')->getHeaders());
        $this->assertEquals($expected, $response->withAddedHeader('Accept', ['application/xml'])->getHeaders());
    }

    /**
     * @test
     */
    public function testWithoutHeader()
    {
        $body = '';
        $headers = ['Accept' => ['application/json'], 'Content-Encoding' => ['gzip']];
        $response = new Response($body, 200, $headers);
        $expected = $headers;
        $this->assertEquals($expected, $response->withoutHeader('Cache-Control')->getHeaders());
        $expected = ['Content-Encoding' => ['gzip']];
        $this->assertEquals($expected, $response->withoutHeader('Accept')->getHeaders());
        $this->assertEquals($expected, $response->withoutHeader('accept')->getHeaders());
    }

    /**
     * @test
     */
    public function testGetBody()
    {
        $body = '';
        $response = new Response($body);
        $this->assertEquals($body, $response->getBody());
    }

    /**
     * @test
     */
    public function testWithBody()
    {
        $body = '{"message":"text"}';
        $stream = $this->prophesize('Psr\Http\Message\StreamInterface');
        $stream->__toString()->willReturn($body);
        $this->assertEquals($body, (new Response(''))->withBody($stream->reveal())->getBody());
    }

    /**
     * @test
     */
    public function testGetStatusCode()
    {
        $this->assertEquals(200, (new Response(''))->getStatusCode());
        $this->assertEquals(400, (new Response('', 400))->getStatusCode());
    }

    /**
     * @test
     */
    public function testWithStatus()
    {
        $statusCode = 200;
        $response = (new Response(''))->withStatus($statusCode);
        $this->assertTrue(
            $statusCode === $response->getStatusCode()
            && $response->getReasonPhrase() === HttpStatusCode::$statusTexts[$statusCode]
        );

        $reasonPhrase = 'value';
        $response = (new Response(''))->withStatus($statusCode, $reasonPhrase);
        $this->assertTrue(
            $statusCode === $response->getStatusCode()
            && $reasonPhrase === $response->getReasonPhrase()
        );
    }
}
