<?php


namespace Chiven\Format;


class Json implements FormatInterface
{
    public function __construct()
    {
        /** Setting up error handler, so it should render all errors in specified format */
        set_error_handler([$this, 'errorHandler']);
    }

    public function errorHandler()
    {
    }
}