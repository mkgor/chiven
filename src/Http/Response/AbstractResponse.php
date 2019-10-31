<?php

namespace Chiven\Http\Response;

use Chiven\Http\Entity\Header;

/**
 * Class AbstractResponse
 * @package Chiven\Http\Response
 */
abstract class AbstractResponse
{
    /**
     * @var Header[]
     */
    private $headers;

    /**
     * @var array|string
     */
    private $body;

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
     * @param Header $header
     */
    public function addHeader(Header $header): void
    {
        $this->headers[$header->getName()] = $header;
    }

    /**
     * @param $name
     * @return Header|null
     */
    public function getHeaderByName($name): ?Header
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    /**
     * @param string $name
     */
    public function removeHeader(string $name): void
    {
        if(isset($this->headers[$name])) {
            unset($this->headers[$name]);
        }
    }

    /**
     * @return array|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array|string $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
}