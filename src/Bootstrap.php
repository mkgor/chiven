<?php


namespace Chiven;


use Chiven\Format\FormatInterface;

class Bootstrap
{
    /**
     * @var FormatInterface
     */
    public $format;

    /**
     * @return FormatInterface
     */
    public function getFormat(): FormatInterface
    {
        return $this->format;
    }

    /**
     * @param FormatInterface $format
     */
    public function setFormat(FormatInterface $format): void
    {
        $this->format = $format;
    }

}