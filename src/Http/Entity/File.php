<?php

namespace Chiven\Http\Entity;

use Chiven\Http\Exception\DirectoryNotFoundException;

/**
 * Class File
 * @package Chiven\Http\Entity
 */
class File implements Insertable
{

    use InsertableTrait;

    /**
     * Name of file
     *
     * @var string
     */
    private $name;

    /**
     * Extension of file
     *
     * @var string
     */
    private $extension;

    /**
     * MIME type of file
     *
     * @var string
     */
    private $mime;

    /**
     * Size of file in bytes
     *
     * @var int
     */
    private $size;

    /**
     * TMP name of file (where it located when just uploaded)
     *
     * @var string
     */
    private $tmp_name;

    /**
     * File constructor.
     *
     * @param string $name
     * @param string $extension
     * @param string $mime
     * @param int    $size
     * @param string $tmp_name
     */
    public function __construct(string $name = null, string $extension = null, string $mime = null, int $size = null, string $tmp_name = null)
    {
        $this->name = $name;
        $this->extension = $extension;
        $this->mime = $mime;
        $this->size = $size;
        $this->tmp_name = $tmp_name;
    }


    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @codeCoverageIgnore
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @codeCoverageIgnore
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     * @codeCoverageIgnore
     */
    public function setMime(string $mime): void
    {
        $this->mime = $mime;
    }

    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @codeCoverageIgnore
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getTmpName(): string
    {
        return $this->tmp_name;
    }

    /**
     * @param string $tmp_name
     * @codeCoverageIgnore
     */
    public function setTmpName(string $tmp_name): void
    {
        $this->tmp_name = $tmp_name;
    }

    /**
     * @param string $storage
     * @throws DirectoryNotFoundException
     */
    public function moveTo(string $storage)
    {
        if(!is_dir($storage)) {
            throw new DirectoryNotFoundException($storage);
        }

        copy($this->getTmpName(), trim($storage, '/') . '/' . $this->getName());
    }
}