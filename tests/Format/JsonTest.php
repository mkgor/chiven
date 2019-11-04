<?php

namespace Test\Format;

use Chiven\Bootstrap;
use Chiven\Format\Json;
use Chiven\Http\Response\Response;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    public function setUp()
    {
        if(!defined('CHIVEN_ENV'))
            define('CHIVEN_ENV', 'test');
    }

    public function testResponseDecorator()
    {
        $format = new Json();
        $response = new Response();
        $response->setBody(['test' => 1]);
        $jsonDecoded = json_decode($format->responseDecorator($response), true);
        $this->assertEquals(['test' => 1], $jsonDecoded);
    }
}
