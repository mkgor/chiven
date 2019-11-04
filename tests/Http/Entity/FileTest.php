<?php


use Chiven\Http\Exception\DirectoryNotFoundException;
use Chiven\Http\Repository\FileRepository;
use Chiven\Http\Request;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    const TEST_FILENAME = 'test';

    /**
     * @var Request
     */
    private $requestInstance;

    /**
     * @var FileRepository
     */
    private $files;

    public function setUp()
    {
        $local_file = __DIR__ . '/test-files/large.jpg';

        $_FILES = array(
            self::TEST_FILENAME => array (
                'tmp_name' => $local_file,
                'name' => 'large.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            )
        );

        $this->requestInstance = new Request();
        $this->requestInstance->fromGlobals();

        $this->files = $this->requestInstance->getFiles();

    }

    public function testMoveTo()
    {
        $this->files->findFirst()->moveTo(__DIR__ . '/test-files/upload');

        $this->assertFileExists(__DIR__ . '/test-files/upload/large.jpg');

        unlink(__DIR__ . '/test-files/upload/large.jpg');
    }

    public function testNotDir()
    {
        $this->expectException(DirectoryNotFoundException::class);

        $this->files->findFirst()->moveTo(__DIR__ . '/test-files/large.jpg');
    }
}
