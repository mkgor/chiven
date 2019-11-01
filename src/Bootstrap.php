<?php

namespace Chiven;

use Chiven\Format\FormatInterface;

/**
 * Class Bootstrap
 * @package Chiven
 */
class Bootstrap
{
    /**
     * @var FormatInterface
     */
    public $format;

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

}