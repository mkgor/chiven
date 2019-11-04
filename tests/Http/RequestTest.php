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

        $filesRepo = $request->getFiles();
        $file = $filesRepo->findFirst();

        $headersRepo = $request->getHeaders();
        $header = $headersRepo->findFirst();

        $this->assertIsObject($file);
        $this->assertIsObject($header);

        $this->assertIsArray($request->getGet());
        $this->assertIsArray($request->getPost());
    }

    public function testFromGlobals()
    {
        $request = new Request();
        $request->fromGlobals();

        $filesRepo = $request->getFiles();
        $file = $filesRepo->findFirst();

        $this->assertEmpty($request->getGet());
        $this->assertEmpty($request->getPost());
        $this->assertIsObject($file);
        $this->assertEmpty($request->getHeaders()->findAll());
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
                'name' => ['large1.jpg', 'small1.jpg'],
                'type' => ['image/jpeg','image/jpeg'],
                'size' => [335057,33507],
                'error' => [0,0],
            ]
        ]);

        $filesRepo = $request->getFiles();
        $this->assertCount(2, $filesRepo->findAll());
    }
}
