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

use MongoDB\BSON\ObjectId;
use PHPUnit\Framework\TestCase;

/**
 * @author Gabriel Polverini <polverini.gabriel@gmail.com>
 *
 * @group Uri
 */
class UriTest extends TestCase
{
    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function testFtpUri()
    {
        $uri = new Uri('ftp://username:password@ftp.example.com:21');
        $this->assertEquals('ftp://username:password@ftp.example.com', (string) $uri);
        $this->assertEquals('ftp', $uri->getScheme());
        $this->assertEquals(21, $uri->getPort());
        $this->assertEquals('username:password@ftp.example.com', $uri->getAuthority());
        $this->assertEquals('username:password', $uri->getUserInfo());
        $this->assertEquals('ftp.example.com', $uri->getHost());
        $this->assertEquals('', $uri->getPath());
        $this->assertEquals('', $uri->getQuery());
        $this->assertEquals('', $uri->getFragment());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidScheme()
    {
        (new Uri('http://www.example.com/'))->withScheme(1);
    }

    /**
     * @test
     */
    public function testWithScheme()
    {
        $value = 'http://www.example.com/';
        $uri = new Uri($value);

        $uriCloned = $uri->withScheme(Scheme::HTTPS);
        $this->assertEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertEquals($uri->getAuthority(), $uriCloned->getAuthority());
        $this->assertEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertNotEquals($value, (string) $uriCloned);
        $this->assertNotEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals(Scheme::HTTPS, $uriCloned->getScheme());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidHost()
    {
        (new Uri('http://www.example.com/'))->withHost(1);
    }

    /**
     * @test
     */
    public function testWithHost()
    {
        $value = 'http://www.example.com/';
        $uri = new Uri($value);

        $host = 'www.clarovideo.com';
        $uriCloned = $uri->withHost($host);
        $this->assertEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertNotEquals($uri->getAuthority(), $uriCloned->getAuthority());
        $this->assertEquals($host, $uriCloned->getAuthority());
        $this->assertEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertNotEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertEquals($host, $uriCloned->getHost());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidPort()
    {
        (new Uri('http://www.example.com/'))->withPort('value');
    }

    /**
     * @test
     */
    public function testWithPort()
    {
        $value = 'http://www.example.com/';
        $uri = new Uri($value);

        $port = 8084;
        $uriCloned = $uri->withPort($port);
        $this->assertEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals($uri->getAuthority().":$port", $uriCloned->getAuthority());
        $this->assertEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertNotEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertEquals($port, $uriCloned->getPort());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidPath()
    {
        (new Uri('http://www.example.com/'))->withPath(1);
    }

    /**
     * @test
     */
    public function testWithPath()
    {
        $value = 'http://www.example.com/';
        $uri = new Uri($value);

        $path = '/ExamplePage.html';
        $uriCloned = $uri->withPath($path);
        $this->assertEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals($uri->getAuthority(), $uriCloned->getAuthority());
        $this->assertEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertNotEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertEquals($path, $uriCloned->getPath());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidQuery()
    {
        (new Uri('http://www.example.com/'))->withQuery(1);
    }

    /**
     * @test
     */
    public function testWithQuery()
    {
        $value = 'http://www.example.com/ExamplePage.html';
        $uri = new Uri($value);

        $query = 'a=1&b=2';
        $uriCloned = $uri->withQuery($query);
        $this->assertEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals($uri->getAuthority(), $uriCloned->getAuthority());
        $this->assertEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertNotEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertEquals($query, $uriCloned->getQuery());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidFragment()
    {
        (new Uri('http://www.example.com/'))->withFragment(1);
    }

    /**
     * @test
     */
    public function testWithFragment()
    {
        $value = 'http://www.example.com/ExamplePage.html';
        $uri = new Uri($value);

        $fragment = 'anchor';
        $uriCloned = $uri->withFragment($fragment);
        $this->assertEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals($uri->getAuthority(), $uriCloned->getAuthority());
        $this->assertEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertNotEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertEquals($fragment, $uriCloned->getFragment());
    }

    /**
     * @test
     */
    public function testWithUserInfo()
    {
        $value = 'http://www.example.com/ExamplePage.html';
        $uri = new Uri($value);

        $user = 'user';
        $password = 'password';
        $uriCloned = $uri->withUserInfo($user, $password);
        $this->assertEquals($uri->getScheme(), $uriCloned->getScheme());
        $this->assertEquals($uri->getHost(), $uriCloned->getHost());
        $this->assertEquals($uri->getPort(), $uriCloned->getPort());
        $this->assertEquals($uri->getPath(), $uriCloned->getPath());
        $this->assertEquals($uri->getQuery(), $uriCloned->getQuery());
        $this->assertEquals($uri->getFragment(), $uriCloned->getFragment());
        $this->assertNotEquals($uri->getUserInfo(), $uriCloned->getUserInfo());
        $this->assertNotEquals($uri->getAuthority(), $uriCloned->getAuthority());
        $this->assertEquals("$user:$password@www.example.com", $uriCloned->getAuthority());
        $this->assertEquals("$user:$password", $uriCloned->getUserInfo());

    }
}
