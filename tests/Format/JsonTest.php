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

    public function testErrorHandler()
    {
        $format = new Json();

        $this->assertEquals([
            'errno' => 1,
            'error' => 'Error',
            'file' => 'error.php',
            'line' => 1
        ], $format->errorHandler(1, 'Error', 'error.php', 1));
    }
}
