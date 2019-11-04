<?php

namespace Chiven\Http;

use Chiven\Http\Entity\File;
use Chiven\Http\Entity\Header;
use Chiven\Http\Repository\FileRepository;
use Chiven\Http\Repository\HeaderRepository;

/**
 * Class Request
 *
 * @package Chiven\Http
 */
class Request
{
    /**
     * @var HeaderRepository
     */
    private $headers;

    /**
     * @var FileRepository
     */
    private $files;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $post;

    /**
     * @var array
     */
    private $get;

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @param array $post
     *
     * @codeCoverageIgnore
     */
    public function setPost(array $post): void
    {
        $this->post = $post;
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @param array $get
     *
     * @codeCoverageIgnore
     */
    public function setGet(array $get): void
    {
        $this->get = $get;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @codeCoverageIgnore
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return HeaderRepository
     * @codeCoverageIgnore
     */
    public function getHeaders(): HeaderRepository
    {
        return $this->headers;
    }

    /**
     * @param Header[] $headers
     *
     * @codeCoverageIgnore
     */
    public function setHeaders(array $headers): void
    {
        $this->headers->set($headers);
    }

    /**
     * @return FileRepository
     * @codeCoverageIgnore
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param File[] $files
     *
     * @codeCoverageIgnore
     */
    public function setFiles(array $files): void
    {
        $this->files->set($files);
    }

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->files = new FileRepository();
        $this->headers = new HeaderRepository();
    }

    /**
     * Configures request object by custom params
     *
     * @param array $files
     * @param array $get
     * @param array $post
     * @param array $headers
     */
    public function initialize(array $files = [], array $get = [], array $post = [], array $headers = [])
    {
        $this->setFiles($this->buildFilesArray($files));
        $this->setGet($get);
        $this->setPost($post);
        $this->setHeaders($this->buildHeadersArray($headers));
    }

    /**
     * Fills up request object from global variables and standard functions
     */
    public function fromGlobals()
    {
        if (!empty($_FILES)) {
            $this->setFiles($this->buildFilesArray($_FILES));
        }

        $this->setHeaders($this->buildHeadersArray(headers_list()));

        if (CHIVEN_ENV != 'test') {
            $this->setBody(file_get_contents('php://stdin'));
        }

        $this->setPost($_POST);
        $this->setGet($_GET);
    }

    /**
     * @param array $files
     *
     * @return File[]
     */
    private function buildFilesArray(array $files)
    {
        $purifiedFileArray = [];
        $fileObjectsArray = [];

        foreach ($files as $fileArray => $item) {
            $checkForArray = end($item);

            if (is_array($checkForArray)) {
                $fileCount = count($checkForArray);

                for ($i = 0; $i < $fileCount; $i++) {
                    $tmp = [];

                    foreach ($item as $fileProperty => $value) {
                        $tmp[$fileProperty] = $files[$fileArray][$fileProperty][$i];
                    }

                    $purifiedFileArray[] = $tmp;
                }
            } else {
                $tmp = [];

                foreach ($item as $property => $value) {
                    $tmp[$property] = $value;
                }

                $purifiedFileArray[] = $tmp;
            }
        }

        foreach ($purifiedFileArray as $fileItem) {
            $fileObjectsArray[] = $this->fileObjectBuilder($fileItem);
        }

        return $fileObjectsArray;
    }

    /**
     * @param array $fileArray
     *
     * @return File
     */
    private function fileObjectBuilder(array $fileArray)
    {
        $file = new File();

        $fileNameExloded = explode('.', $fileArray['name']);

        $file->setName($fileArray['name']);
        $file->setSize($fileArray['size']);
        $file->setExtension(array_pop($fileNameExloded));
        $file->setMime($fileArray['type']);
        $file->setTmpName($fileArray['tmp_name']);

        return $file;
    }

    /**
     * @param array $headers
     *
     * @return Header[]
     */
    private function buildHeadersArray(array $headers)
    {
        $headersObjectArray = [];

        foreach ($headers as $header) {
            $headerExploded = explode(':', $header);
            $headersObjectArray[] = $this->headerObjectBuilder([
                'name'  => $headerExploded[0],
                'value' => trim($headerExploded[1]),
            ]);
        }

        return $headersObjectArray;
    }

    /**
     * @param array $headerArray
     *
     * @return Header
     */
    private function headerObjectBuilder(array $headerArray)
    {
        $header = new Header();

        $header->setName($headerArray['name']);
        $header->setValue($headerArray['value']);

        return $header;
    }
}