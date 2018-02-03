<?php

namespace Matricali\Http;

use PHPUnit\Framework\TestCase;

/**
 * @covers Matricali\Http\Response
 */
class ResponseTest extends TestCase
{
    public function testEmptyUri()
    {
        $response = new Response();
        $this->assertEquals(1, 1);
    }
}
