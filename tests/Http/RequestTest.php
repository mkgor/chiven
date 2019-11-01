<?php


use Chiven\Http\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    public function testInitialize()
    {
        $request = new Request();
        $request->initialize([
                'test' => [
                    'tmp_name' => '/tmp/asd30dvso',
                    'name' => 'large.jpg',
                    'type' => 'image/jpeg',
                    'size' => 335057,
                    'error' => 0,
                ]
            ],
            [
                'get' => 'value'
            ],
            [
                'post' => 'value'
            ],
            [
                'X-Test-Header: value'
            ]
        );

        $fileArray = $request->getFiles();
        $file = array_pop($fileArray);

        $headerArray = $request->getHeaders();
        $header = array_pop($headerArray);

        $this->assertIsObject($file);
        $this->assertIsObject($header);

        $this->assertIsArray($request->getGet());
        $this->assertIsArray($request->getPost());
    }

    public function testFromGlobals()
    {
        $request = new Request();
        $request->fromGlobals();

        $fileArray = $request->getFiles();
        $file = array_pop($fileArray);

        $this->assertEmpty($request->getGet());
        $this->assertEmpty($request->getPost());
        $this->assertIsObject($file);
        $this->assertEmpty($request->getHeaders());
    }

    /**
     * @runInSeparateProcess
     */
    public function testMultipleFiles()
    {
        $request = new Request();
        $request->initialize([
            'test' => [
                'tmp_name' => ['/tmp/asd30dvso','/tmp/sdgv424df'],
                'name' => ['large.jpg', 'small.jpg'],
                'type' => ['image/jpeg','image/jpeg'],
                'size' => [335057,33507],
                'error' => [0,0],
            ]
        ]);

        $fileArray = $request->getFiles();
        $this->assertCount(2, $fileArray);
    }
}
