<?php

namespace Chiven;

use Chiven\Format\FormatInterface;
use Chiven\Format\Json;
use Chiven\Http\Entity\File;
use Chiven\Http\Entity\Header;
use Chiven\Http\Repository\FileRepository;
use Chiven\Http\Repository\HeaderRepository;
use Chiven\Http\Repository\RepositoryInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class Bootstrap
 * @package Chiven
 */
class Bootstrap
{
    /**
     * @var FormatInterface
     */
    private $format;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $files;

    /**
     * @var RequestInterface
     */
    private static $request;

    /**
     * @var RepositoryInterface
     */
    private static $fileRepository;

    /**
     * @var RepositoryInterface
     */
    private static $headerRepository;

    /**
     * @return RepositoryInterface
     */
    public static function getFileRepository(): RepositoryInterface
    {
        return self::$fileRepository;
    }

    /**
     * @param RepositoryInterface $fileRepository
     */
    public static function setFileRepository(RepositoryInterface $fileRepository): void
    {
        self::$fileRepository = $fileRepository;
    }

    /**
     * @return RepositoryInterface
     */
    public static function getHeaderRepository(): RepositoryInterface
    {
        return self::$headerRepository;
    }

    /**
     * @param RepositoryInterface $headerRepository
     */
    public static function setHeaderRepository(RepositoryInterface $headerRepository): void
    {
        self::$headerRepository = $headerRepository;
    }


    /**
     * @return array
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }

    /**
     * @return RequestInterface
     * @codeCoverageIgnore
     */
    public static function getRequest(): RequestInterface
    {
        return self::$request;
    }

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request): void
    {
        self::$request = $request;
    }

    /**
     * @return FormatInterface
     * @codeCoverageIgnore
     */
    public function getFormat(): FormatInterface
    {
        return $this->format;
    }

    /**
     * @param FormatInterface $format
     * @codeCoverageIgnore
     */
    public function setFormat(FormatInterface $format): void
    {
        $this->format = $format;

        /** Setting up error handler, so it should render all errors in specified format */
        set_error_handler([$format, 'errorHandler']);
    }

    /**
     * Bootstrap constructor.
     *
     * @param RequestInterface $request
     * @param FormatInterface|null $format
     * @param array|null $files
     * @param array|null $headers
     */
    public function __construct(RequestInterface $request = null, ?FormatInterface $format = null, $files = null, $headers = null)
    {
        if ($format == null) {
            $format = new Json();
        }

        $this->setFiles(($files == null) ? $_FILES : $files);
        $this->setHeaders(($files == null) ? headers_list() : $headers);

        $this->setRequest($request);

        self::setFileRepository(new FileRepository());
        self::setHeaderRepository(new HeaderRepository());

        self::getFileRepository()->setContainer($this->buildFilesArray($this->getFiles()));
        self::getHeaderRepository()->setContainer($this->buildHeadersArray($this->getHeaders()));

        $this->setFormat($format);
    }

    /**
     * @param array $files
     *
     * @return File[]
     */
    private function buildFilesArray(?array $files)
    {
        $fileObjectsArray = [];

        if ($files != null) {
            $purifiedFileArray = [];

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
     * fdsfs:fds
     * fsfs
     * @return Header[]
     */
    private function buildHeadersArray(?array $headers)
    {
        $headersObjectArray = [];

        if ($headers != null) {
            foreach ($headers as $k => $v) {
                if(is_numeric($k)) {
                    $headerExploded = explode(':', $v);

                    list($header, $value) = $headerExploded;
                } else {
                    list($header, $value) = [$k, $v];
                }

                $headersObjectArray[] = $this->headerObjectBuilder([
                    'name' => trim($header),
                    'value' => trim($value),
                ]);
            }
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