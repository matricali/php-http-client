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
class HttpMethodTest extends TestCase
{
    const NAME_GET = 'GET';
    const NAME_POST = 'POST';
    const NAME_PUT = 'PUT';
    const NAME_HEAD = 'HEAD';
    const NAME_DELETE = 'DELETE';
    const NAME_PATCH = 'PATCH';
    const NAME_CONNECT = 'CONNECT';
    const NAME_OPTIONS = 'OPTIONS';
    const NAME_TRACE = 'TRACE';
    const NAME_NOTEXIST = '';

    protected $httpMethod;

    public function setUp()
    {
        $this->httpMethod = $this->getMockForAbstractClass('Matricali\Http\HttpMethod');
    }

    /**
     * @test
     */
    public function testIsValidNameGet()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_GET));
    }

    /**
     * @test
     */
    public function testGetByNameGet()
    {
        $value = $this->httpMethod->getByName(self::NAME_GET);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameGet
     *
     * @param string $value
     */
    public function testIsValidValueGet($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNamePost()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_POST));
    }

    /**
     * @test
     */
    public function testGetByNamePost()
    {
        $value = $this->httpMethod->getByName(self::NAME_POST);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNamePost
     *
     * @param string $value
     */
    public function testIsValidValuePost($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNamePut()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_PUT));
    }

    /**
     * @test
     */
    public function testGetByNamePut()
    {
        $value = $this->httpMethod->getByName(self::NAME_PUT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNamePut
     *
     * @param string $value
     */
    public function testIsValidValuePut($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameHead()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_HEAD));
    }

    /**
     * @test
     */
    public function testGetByNameHead()
    {
        $value = $this->httpMethod->getByName(self::NAME_HEAD);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameHead
     *
     * @param string $value
     */
    public function testIsValidValueHead($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameDelete()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_DELETE));
    }

    /**
     * @test
     */
    public function testGetByNameDelete()
    {
        $value = $this->httpMethod->getByName(self::NAME_DELETE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameDelete
     *
     * @param string $value
     */
    public function testIsValidValueDelete($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNamePatch()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_PATCH));
    }

    /**
     * @test
     */
    public function testGetByNamePatch()
    {
        $value = $this->httpMethod->getByName(self::NAME_PATCH);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNamePatch
     *
     * @param string $value
     */
    public function testIsValidValuePatch($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameConnect()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_CONNECT));
    }

    /**
     * @test
     */
    public function testGetByNameConnect()
    {
        $value = $this->httpMethod->getByName(self::NAME_CONNECT);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameConnect
     *
     * @param string $value
     */
    public function testIsValidValueConnect($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameOptions()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_OPTIONS));
    }

    /**
     * @test
     */
    public function testGetByNameOptions()
    {
        $value = $this->httpMethod->getByName(self::NAME_OPTIONS);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameOptions
     *
     * @param string $value
     */
    public function testIsValidValueOptions($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameTrace()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_TRACE));
    }

    /**
     * @test
     */
    public function testGetByNameTrace()
    {
        $value = $this->httpMethod->getByName(self::NAME_TRACE);
        $this->assertNotNull($value);
        return $value;
    }

    /**
     * @test
     * @depends testGetByNameTrace
     *
     * @param string $value
     */
    public function testIsValidValueTrace($value)
    {
        $this->assertTrue($this->httpMethod->isValidValue($value));
    }

    /**
     * @test
     */
    public function testIsValidNameStrictTrue()
    {
        $this->assertTrue($this->httpMethod->isValidName(self::NAME_GET, true));
    }

    /**
     * @test
     */
    public function testGetByNameNotExist()
    {
        $this->assertNull($this->httpMethod->getByName(self::NAME_NOTEXIST));
    }
}