<?php

namespace Chiven\Format;

/**
 * Interface FormatInterface
 * @package Chiven\Format
 */
interface FormatInterface
{
    public function build($body);

    /**
     * @param int $errno The first parameter, errno, contains the level of the error raised, as an integer.
     * @param string $errstr  The second parameter, errstr, contains the error message, as a string.
     * @param string $errfile  The third parameter is optional, errfile, which contains the filename that the error was raised in, as a string.
     * @param int $errline The fourth parameter is optional, errline, which contains the line number the error was raised at, as an integer.
     * @return mixed
     */
    public function errorHandler(int $errno , string $errstr, string $errfile, int $errline);
}