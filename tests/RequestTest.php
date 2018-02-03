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
 * @covers Matricali\Http\Request
 */
class RequestTest extends TestCase
{
    public function testBasicTest()
    {
        $uri = 'https://www.google.com/';
        $headers = [];
        $request = new Request('GET', $uri, $headers);
        $this->assertEquals($uri, (string) $request->getUri());
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertEquals('1.1', $request->getProtocolVersion());
        $this->assertEquals('', $request->getBody());
        $this->assertEquals($uri, $request->getRequestTarget());

        $request = new Request('HEAD', '');
        $this->assertEquals('HEAD', $request->getMethod());
        $this->assertEquals('/', $request->getRequestTarget());
    }

    public function testHeaders()
    {
        $uri = 'https://www.google.com/';
        $headers = [
            'Accept' => 'application/json'
        ];
        $headers2 = [
            'Accept' => [
                'application/json'
            ]
        ];
        $request = new Request('GET', $uri, $headers);
        $this->assertEquals($uri, (string) $request->getUri());
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($headers2, $request->getHeaders());
        $this->assertTrue($request->hasHeader('Accept'));
        $this->assertFalse($request->hasHeader('Authorization'));
        $this->assertEquals([$headers['Accept']], $request->getHeader('Accept'));
        $this->assertEquals([], $request->getHeader('Authorization'));
        $this->assertEquals($headers['Accept'], $request->getHeaderLine('Accept'));
        $this->assertEquals('', $request->getHeaderLine('Authorization'));

        $request = new Request('GET', '', $headers2);
        $this->assertEquals($headers2, $request->getHeaders());
    }
}
