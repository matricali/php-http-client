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
 * @covers Matricali\Http\Uri
 */
class UriTest extends TestCase
{
    public function testEmptyUri()
    {
        $uri = new Uri();
        $this->assertEquals('', (string) $uri);
        $this->assertEquals('', $uri->getScheme());
        $this->assertEquals('', $uri->getPort());
        $this->assertEquals('', $uri->getAuthority());
        $this->assertEquals('', $uri->getUserInfo());
        $this->assertEquals('', $uri->getHost());
        $this->assertEquals('', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('', $uri->getFragment());
    }

    public function testBasicHttpUri()
    {
        $uri = new Uri('http://www.google.com/');
        $this->assertEquals('http://www.google.com/', (string) $uri);
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals(null, $uri->getPort());
        $this->assertEquals('www.google.com', $uri->getAuthority());
        $this->assertEquals('', $uri->getUserInfo());
        $this->assertEquals('www.google.com', $uri->getHost());
        $this->assertEquals('/', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('', $uri->getFragment());
    }

    public function testHttpUriWithUsername()
    {
        $uri = new Uri('http://user@www.google.com/');
        $this->assertEquals('http://user@www.google.com/', (string) $uri);
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals(null, $uri->getPort());
        $this->assertEquals('user@www.google.com', $uri->getAuthority());
        $this->assertEquals('user', $uri->getUserInfo());
        $this->assertEquals('www.google.com', $uri->getHost());
        $this->assertEquals('/', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('', $uri->getFragment());
    }

    public function testHttpUriWithUsernameAndPassword()
    {
        $uri = new Uri('http://user:password@www.google.com/');
        $this->assertEquals('http://user:password@www.google.com/', (string) $uri);
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals(null, $uri->getPort());
        $this->assertEquals('user:password@www.google.com', $uri->getAuthority());
        $this->assertEquals('user:password', $uri->getUserInfo());
        $this->assertEquals('www.google.com', $uri->getHost());
        $this->assertEquals('/', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('', $uri->getFragment());
    }

    public function testHttpUriWithPathQueryAndFragmentHttps()
    {
        $uri = new Uri('https://www.google.com:9000/ExampleResource?a=1&b=2#top');
        $this->assertEquals('https://www.google.com:9000/ExampleResource?a=1&b=2#top', (string) $uri);
        $this->assertEquals('https', $uri->getScheme());
        $this->assertEquals(9000, $uri->getPort());
        $this->assertEquals('www.google.com:9000', $uri->getAuthority());
        $this->assertEquals('', $uri->getUserInfo());
        $this->assertEquals('www.google.com', $uri->getHost());
        $this->assertEquals('/ExampleResource', $uri->getPath());
        $this->assertEquals('a=1&b=2', $uri->getQuery());
        $this->assertEquals('top', $uri->getFragment());
    }

    public function testHttpUriWithPathQueryAndFragmentHttp()
    {
        $uri = new Uri('http://www.example.com:8080/ExamplePage.html?#anchor');
        $this->assertEquals('http://www.example.com:8080/ExamplePage.html#anchor', (string) $uri);
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals(8080, $uri->getPort());
        $this->assertEquals('www.example.com:8080', $uri->getAuthority());
        $this->assertEquals('', $uri->getUserInfo());
        $this->assertEquals('www.example.com', $uri->getHost());
        $this->assertEquals('/ExamplePage.html', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('anchor', $uri->getFragment());
    }

    public function testFtpUri()
    {
        $uri = new Uri('ftp://username:password@ftp.example.com:21');
        $this->assertEquals('ftp://username:password@ftp.example.com:21', (string) $uri);
        $this->assertEquals('ftp', $uri->getScheme());
        $this->assertEquals(21, $uri->getPort());
        $this->assertEquals('username:password@ftp.example.com:21', $uri->getAuthority());
        $this->assertEquals('username:password', $uri->getUserInfo());
        $this->assertEquals('ftp.example.com', $uri->getHost());
        $this->assertEquals('', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('', $uri->getFragment());
    }
}
