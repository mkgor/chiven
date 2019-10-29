<?php

namespace Chiven\Http\Exception;

use Throwable;

/**
 * Class FileUploadException
 * @package Chiven\Http\Exception
 */
class FileUploadException extends \Exception
{
    /**
     * FileUploadException constructor.
     * @param string $file
     */
    public function __construct($file = "")
    {
        parent::__construct('File ' . $file . ' not uploaded', 500);
    }
}