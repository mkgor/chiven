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
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return Header[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param Header[] $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files): void
    {
        $this->files = $files;
    }

    /**
     * @param array $files
     */
    public function initialize(array $files = [])
    {
        $this->setFiles($this->buildFilesArray($files));
    }

    public function fromGlobals()
    {
        if(!empty($_FILES)) {
            $this->setFiles($this->buildFilesArray($_FILES));
        }

        $this->setHeaders($this->buildHeadersArray(headers_list()));
    }

    /**
     * @param array $files
     * @return File[]
     */
    private function buildFilesArray(array $files)
    {
        $fileObjectsArray = [];
        $fileCount = count($files['name']);

        $purifiedFileArray = [];

        for ($i = 0; $i < $fileCount; $i++) {
            $tmp = [];

            foreach ($files as $fileProperty => $value) {
                foreach ($value as $key => $item) {
                    $tmp[$fileProperty] = $files[$fileProperty][$i];
                }
            }

            $purifiedFileArray[] = $tmp;
        }

        foreach ($purifiedFileArray as $item) {
            $fileObjectsArray[] =  $this->fileObjectBuilder($item);
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