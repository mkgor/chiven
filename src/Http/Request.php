<?php

namespace Chiven\Http;

use Chiven\Http\Entity\File;
use Chiven\Http\Entity\Header;

/**
 * Class Request
 * @package Chiven\Http
 */
class Request
{
    /**
     * @var Header[]
     */
    private $headers;

    /**
     * @var File[]
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
     * @codeCoverageIgnore
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return Header[]
     * @codeCoverageIgnore
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param Header[] $headers
     * @codeCoverageIgnore
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     * @codeCoverageIgnore
     */
    public function setFiles($files): void
    {
        $this->files = $files;
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
        if(!empty($_FILES)) {
            $this->setFiles($this->buildFilesArray($_FILES));
        }

        $this->setHeaders($this->buildHeadersArray(headers_list()));

        if(CHIVEN_ENV != 'test') {
            $this->setBody(file_get_contents('php://stdin'));
        }

        $this->setPost($_POST);
        $this->setGet($_GET);
    }

    /**
     * @param array $files
     * @return File[]
     */
    private function buildFilesArray(array $files)
    {
        $fileObjectsArray = [];
        $file = end($files);

        if(is_array($file['name'])) {
            $fileCount = count($file);

            $purifiedFileArray = [];

            for ($i = 0; $i < $fileCount; $i++) {
                $tmp = [];

                foreach ($files as $fileProperty => $value) {
                    foreach ($value as $key => $item) {
                        var_dump($item);
                        $tmp[$fileProperty] = $files[$fileProperty][$key][$i];
                    }
                }

                $purifiedFileArray[] = $tmp;
            }

            foreach ($purifiedFileArray as $item) {
                $fileObjectsArray[] = $this->fileObjectBuilder($item);
            }
        } else {
            $fileObjectsArray[key($files)] = $this->fileObjectBuilder($file);
        }

        return $fileObjectsArray;
    }

    /**
     * @param array $fileArray
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
     * @return Header[]
     */
    private function buildHeadersArray(array $headers)
    {
        $headersObjectArray = [];

        foreach($headers as $header) {
            $headerExploded = explode(':', $header);
            $headersObjectArray[] = $this->headerObjectBuilder([
                'name' => $headerExploded[0],
                'value' => trim($headerExploded[1])
            ]);
        }

        return $headersObjectArray;
    }

    /**
     * @param array $headerArray
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