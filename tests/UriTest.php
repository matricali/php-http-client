<?php

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
