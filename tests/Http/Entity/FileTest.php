<?php


use Chiven\Http\Entity\File;

class FileTest extends \PHPUnit\Framework\TestCase
{
    const TEST_FILENAME = 'test';

    /**
     * @var \Chiven\Http\Request
     */
    private $requestInstance;

    /**
     * @var File[]
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

        $this->requestInstance = new \Chiven\Http\Request();
        $this->requestInstance->fromGlobals();

        $this->files = $this->requestInstance->getFiles();

    }

    /**
     * @throws \Chiven\Http\Exception\DirectoryNotFoundException
     * @throws \Chiven\Http\Exception\FileUploadException
     */
    public function testMoveTo()
    {
        $this->files[self::TEST_FILENAME]->moveTo(__DIR__ . '/test-files/upload');

        $this->assertFileExists(__DIR__ . '/test-files/upload/large.jpg');

        unlink(__DIR__ . '/test-files/upload/large.jpg');
    }

    /**
     * @throws \Chiven\Http\Exception\DirectoryNotFoundException
     * @throws \Chiven\Http\Exception\FileUploadException
     */
    public function testNotDir()
    {
        $this->expectException(\Chiven\Http\Exception\DirectoryNotFoundException::class);

        $this->files['test']->moveTo(__DIR__ . '/test-files/large.jpg');
    }
}
