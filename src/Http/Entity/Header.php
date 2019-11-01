<?php

namespace Chiven\Http\Entity;

/**
 * Class Header
 * @package Chiven\Http\Entity
 */
class Header
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * Header constructor.
     *
     * @param string $name
     * @param string $value
     * @codeCoverageIgnore
     */
    public function __construct(string $name = null, string $value = null)
    {
        $this->name = $name;
        $this->value = $value;
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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @codeCoverageIgnore
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function assignHeader(): void
    {
        if(!headers_sent()) {
            header($this->getName() . ': ' . $this->getValue());
        }
    }
}