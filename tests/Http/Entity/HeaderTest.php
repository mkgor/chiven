<?php


use Chiven\Http\Entity\Header;

class HeaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testAssignHeader()
    {
        $header = new Header('X-test-header', 'Test');
        $header->assignHeader();

        $this->assertEquals('X-test-header: Test', xdebug_get_headers()[0]);
    }
}
