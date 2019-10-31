<?php

namespace Chiven\Format;

use Chiven\Http\Entity\Header;
use Chiven\Http\Response\AbstractResponse;
use Chiven\Http\Response\Response;

/**
 * Class Json
 * @package Chiven\Format
 */
class Json implements FormatInterface
{
    /**
     * @param AbstractResponse $response
     * @return false|mixed|string
     */
    public function responseDecorator(AbstractResponse $response)
    {
        if($response->getHeaderByName('Content-type') == null) {
            $response->addHeader(new Header('Content-type', 'application/json'));
        }

        foreach($response->getHeaders() as $header) {
            $header->assignHeader();
        }

        return is_array($response->getBody()) ? json_encode($response->getBody()) : json_encode([$response->getBody()]);
    }

    /**
     * @param int $errno The first parameter, errno, contains the level of the error raised, as an integer.
     * @param string $errstr The second parameter, errstr, contains the error message, as a string.
     * @param string $errfile The third parameter is optional, errfile, which contains the filename that the error was raised in, as a string.
     * @param int $errline The fourth parameter is optional, errline, which contains the line number the error was raised at, as an integer.
     * @return mixed
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline)
    {
        $response = new Response();
        $response->setBody([
            'errno' => $errno,
            'error' => $errstr,
            'file' => $errfile,
            'line' => $errline
        ]);

        exit($this->responseDecorator($response));
    }

}