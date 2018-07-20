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
use Prophecy\Argument;

/**
 * @author Gabriel Polverini <polverini.gabriel@gmail.com>
 *
 * @group Request
 */
class RequestTest extends TestCase
{
    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInstanceInvalidMethodParam()
    {
        new Request('NONE');
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInstanceInvalidBodyParam()
    {
        new Request(HttpMethod::GET, '', [], 1);
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    public function testSearchHeader()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $request = new Request(HttpMethod::GET, '', $headers);

        $reflection = new \ReflectionClass($request);
        $method = $reflection->getMethod('searchHeader');
        $method->setAccessible(true);
        $this->assertFalse($method->invoke($request, 'Content-Encoding'));
        $this->assertFalse($method->invoke($request, 'content-encoding'));
        $expected = 'Accept';
        $this->assertEquals($expected, $method->invoke($request, 'Accept'));
        $this->assertEquals($expected, $method->invoke($request, 'accept'));
        $expected = 'Content-Type';
        $this->assertEquals($expected, $method->invoke($request, 'Content-Type'));
        $this->assertEquals($expected, $method->invoke($request, 'content-type'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetRequestTarget()
    {
        $request = new Request(HttpMethod::GET, '');
        $this->assertEquals('/', $request->getRequestTarget());

        $uri = 'https://www.google.com/';
        $request = new Request(HttpMethod::GET, $uri);
        $this->assertEquals($uri, $request->getRequestTarget());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithRequestTarget()
    {
        $headers = ['Accept' => ['application/json']];
        $request = new Request(HttpMethod::GET, '', $headers);
        $this->assertEquals($request->getRequestTarget(), $request->withRequestTarget('')->getRequestTarget());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetMethod()
    {
        $method = HttpMethod::GET;
        $request = new Request($method);
        $this->assertEquals($method, $request->getMethod());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithMethod()
    {
        $request = new Request();
        $this->assertEquals($request->getMethod(), $request->withMethod(HttpMethod::GET)->getMethod());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidMethod()
    {
        $request = new Request();
        $this->assertEquals($request->getMethod(), $request->withMethod('NONE')->getMethod());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetUri()
    {
        $uri = 'https://www.google.com/';
        $request = new Request(HttpMethod::GET, $uri);
        $this->assertEquals($uri, $request->getUri());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithUri()
    {
        $uri = 'www.google.com';
        $uriInterface = $this->prophesize('Psr\Http\Message\UriInterface');
        $uriInterface->__toString()->willReturn($uri);
        $request = new Request(HttpMethod::GET, $uri);
        $this->assertEquals($request->getUri(), (string) $request->withUri($uriInterface->reveal())->getUri());
        $uriInterface->__toString()->willReturn('www.example.com');
        $this->assertNotEquals($request->getUri(), (string) $request->withUri($uriInterface->reveal())->getUri());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetProtocolVersion()
    {
        $request = new Request();
        $this->assertEquals('1.1', $request->getProtocolVersion());
        $protocolVersion = '1.0';
        $this->assertEquals($protocolVersion, $request->withProtocolVersion($protocolVersion)->getProtocolVersion());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithProtocolVersion()
    {
        $request = new Request();
        $protocolVersion = $request->getProtocolVersion();
        $this->assertEquals($protocolVersion, $request->withProtocolVersion('1.1')->getProtocolVersion());
        $this->assertNotEquals($protocolVersion, $request->withProtocolVersion('1.0')->getProtocolVersion());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetHeaders()
    {
        $this->assertTrue(is_array((new Request())->getHeaders()));

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $expected = [
            'Accept' => ['application/json'],
            'Content-Type' => ['text/xml;charset=UTF-8'],
        ];
        $this->assertEquals($expected, (new Request(HttpMethod::GET, '', $headers))->getHeaders());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testHasHeader()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $request = new Request(HttpMethod::GET, '', $headers);
        $this->assertFalse($request->hasHeader('Content-Encoding'));
        $this->assertFalse($request->hasHeader('content-encoding'));
        $this->assertTrue($request->hasHeader('Accept'));
        $this->assertTrue($request->hasHeader('accept'));
        $this->assertTrue($request->hasHeader('Content-Type'));
        $this->assertTrue($request->hasHeader('content-type'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetHeader()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'text/xml;charset=UTF-8',
        ];
        $request = new Request(HttpMethod::GET, '', $headers);
        $expected = [];
        $this->assertEquals($expected, $request->getHeader('Content-Encoding'));
        $this->assertEquals($expected, $request->getHeader('content-encoding'));
        $expected = ['application/json'];
        $this->assertEquals($expected, $request->getHeader('Accept'));
        $this->assertEquals($expected, $request->getHeader('accept'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetHeaderLine()
    {
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
        $request = new Request(HttpMethod::GET, '', $headers);
        $expected = '';
        $this->assertEquals($expected, $request->getHeaderLine('Content-Encoding'));
        $this->assertEquals($expected, $request->getHeaderLine('content-encoding'));
        $expected = 'application/json';
        $this->assertEquals($expected, $request->getHeaderLine('Accept'));
        $this->assertEquals($expected, $request->getHeaderLine('accept'));
        $expected = 'text/xml;charset=UTF-8';
        $this->assertEquals($expected, $request->getHeaderLine('Content-Type'));
        $this->assertEquals($expected, $request->getHeaderLine('content-type'));
        $expected = implode(', ', $headers['Cache-Control']);
        $this->assertEquals($expected, $request->getHeaderLine('Cache-Control'));
        $this->assertEquals($expected, $request->getHeaderLine('cache-control'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithHeader()
    {
        $headers = ['Accept' => ['application/json']];
        $request = new Request(HttpMethod::GET, '', $headers);
        $expected = array_merge($headers, ['Content-Encoding' => ['gzip']]);
        $this->assertEquals($expected, $request->withHeader('Content-Encoding', 'gzip')->getHeaders());
        $this->assertEquals($expected, $request->withHeader('Content-Encoding', ['gzip'])->getHeaders());
        $expected = ['Accept' => ['application/xml']];
        $this->assertEquals($expected, $request->withHeader('Accept', 'application/xml')->getHeaders());
        $this->assertEquals($expected, $request->withHeader('Accept', ['application/xml'])->getHeaders());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithAddedHeader()
    {
        $headers = ['Accept' => ['application/json']];
        $request = new Request(HttpMethod::GET, '', $headers);
        $expected = array_merge($headers, ['Content-Encoding' => ['gzip']]);
        $this->assertEquals($expected, $request->withAddedHeader('Content-Encoding', 'gzip')->getHeaders());
        $this->assertEquals($expected, $request->withAddedHeader('Content-Encoding', ['gzip'])->getHeaders());
        $expected = ['Accept' => ['application/json', 'application/xml']];
        $this->assertEquals($expected, $request->withAddedHeader('Accept', 'application/xml')->getHeaders());
        $this->assertEquals($expected, $request->withAddedHeader('Accept', ['application/xml'])->getHeaders());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithoutHeader()
    {
        $headers = ['Accept' => ['application/json'], 'Content-Encoding' => ['gzip']];
        $request = new Request(HttpMethod::GET, '', $headers);
        $expected = $headers;
        $this->assertEquals($expected, $request->withoutHeader('Cache-Control')->getHeaders());
        $expected = ['Content-Encoding' => ['gzip']];
        $this->assertEquals($expected, $request->withoutHeader('Accept')->getHeaders());
        $this->assertEquals($expected, $request->withoutHeader('accept')->getHeaders());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testGetBody()
    {
        $body = '{"message":"text"}';
        $request = new Request(HttpMethod::GET, '', [], $body);
        $this->assertEquals($body, $request->getBody());
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function testWithBody()
    {
        $body = '{"message":"text"}';
        $stream = $this->prophesize('Psr\Http\Message\StreamInterface');
        $stream->__toString()->willReturn($body);
        $this->assertEquals($body, (new Request())->withBody($stream->reveal())->getBody());
    }
}
