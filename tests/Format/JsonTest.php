<?php

namespace Test\Format;

use Chiven\Bootstrap;
use Chiven\Format\Json;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Request;

class JsonTest extends TestCase
{
    public function setUp()
    {
        if(!defined('CHIVEN_ENV'))
            define('CHIVEN_ENV', 'test');

        (new Bootstrap(new Request()));
    }

    public function testBuild()
    {
        $format = new Json();

        $jsonDecoded = json_decode((string)($format->build(['test' => 1])->getBody()), true);
        $this->assertEquals(['test' => 1], $jsonDecoded);
    }
}
