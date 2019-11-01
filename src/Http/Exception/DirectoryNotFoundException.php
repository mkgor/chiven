<?php

namespace Chiven\Http\Exception;

use Throwable;

/**
 * Class DirectoryNotFoundException
 * @package Chiven\Http\Exception
 * @codeCoverageIgnore
 */
class DirectoryNotFoundException extends \Exception
{
    /**
     * DirectoryNotFoundException constructor.
     * @param string $dir
     */
    public function __construct($dir = "")
    {
        parent::__construct('Directory ' . $dir . ' not exists', 500);
    }
}