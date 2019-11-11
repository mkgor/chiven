<?php


use Chiven\Bootstrap;

class BootstrapTest extends \PHPUnit\Framework\TestCase
{
    public function test__construct()
    {
        $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

        $format = new \Chiven\Format\Json();

        $chiven = new \Chiven\Bootstrap($request, $format, [
            'test' => [
                'tmp_name' => ['file1', 'file2'],
                'name' => ['file1.jpg', 'file1.jpg'],
                'type' => ['image/jpeg', 'image/jpeg'],
                'size' => [335057, 335057],
                'error' => [0, 0],
            ]
        ], [
            'X-Test-Header: 1',
            'X-Test-Header: 2',
        ]);

        $headerRepository = Bootstrap::getHeaderRepository();
        $fileRepository = Bootstrap::getFileRepository();

        $this->assertCount(2, $fileRepository->findAll());
        $this->assertCount(1, $headerRepository->findAll());

        $this->assertEquals(2, $headerRepository->findFirst()->getValue());
        $this->assertEquals('file2', $fileRepository->findLast()->getTmpName());
    }
}
