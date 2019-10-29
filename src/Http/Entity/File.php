<?php

namespace Chiven\Http\Entity;

/**
 * Class File
 * @package Chiven\Http\Entity
 */
class File
{
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     */
    public function setMime(string $mime): void
    {
        $this->mime = $mime;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getTmpName(): string
    {
        return $this->tmp_name;
    }

    /**
     * @param string $tmp_name
     */
    public function setTmpName(string $tmp_name): void
    {
        $this->tmp_name = $tmp_name;
    }


}