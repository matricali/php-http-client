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
 * @author Gabriel Polverini <polverini.gabriel@gmail.com>
 *
 * @group Enums
 */
class SchemeTest extends TestCase
{
    const NAME_HTTP = 'HTTP';
    const NAME_HTTPS = 'HTTPS';
    const NAME_FTP = 'FTP';
    const NAME_NOTEXIST = '';

    protected $scheme;

    public function setUp()
    {
        $this->scheme = $this->getMockForAbstractClass('Matricali\Http\Scheme');
    }

    /**
     * @test
     */
    public function testIsValidNameHttp()
    {
        $this->assertTrue($this->scheme->isValidName(self::NAME_HTTP));
    }

    /**
     * @test
     */
    public function testGetByNameHttp()
    {
        $value = $this->scheme->getByName(self::NAME_HTTP);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttp
     *
     * @param string $value
     */
    public function testIsValidValueHttp($value)
    {
        $this->assertTrue($this->scheme->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHttps()
    {
        $this->assertTrue($this->scheme->isValidName(self::NAME_HTTPS));
    }

    /**
     * @test
     */
    public function testGetByNameHttps()
    {
        $value = $this->scheme->getByName(self::NAME_HTTPS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHttps
     *
     * @param string $value
     */
    public function testIsValidValueHttps($value)
    {
        $this->assertTrue($this->scheme->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameFtp()
    {
        $this->assertTrue($this->scheme->isValidName(self::NAME_FTP));
    }

    /**
     * @test
     */
    public function testGetByNameFtp()
    {
        $value = $this->scheme->getByName(self::NAME_FTP);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameFtp
     *
     * @param string $value
     */
    public function testIsValidValueFtp($value)
    {
        $this->assertTrue($this->scheme->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameStrictTrue()
    {
        $this->assertTrue($this->scheme->isValidName(self::NAME_HTTP, true));
    }

    /**
     * @test
     */
    public function testGetByNameNotExist()
    {
        $this->assertNull($this->scheme->getByName(self::NAME_NOTEXIST));
    }
}