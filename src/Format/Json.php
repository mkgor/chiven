<?php

namespace Chiven\Format;

use Chiven\Bootstrap;
use Chiven\Http\Entity\Header;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

/**
 * Class Json
 *
 * @package Chiven\Format
 */
class Json implements FormatInterface
{
    /**
     * @param string|array $body
     * @param int $code
     * @return ResponseInterface
     */
    public function build($body = null, $code = 200)
    {
        if (Bootstrap::getHeaderRepository()->findBy('name', 'Content-type') == null) {
            Bootstrap::getHeaderRepository()->insert(new Header('Content-type', 'application/json'));
        }

        /** @var Header $header */
        foreach (Bootstrap::getHeaderRepository()->findAll() as $header) {
            $header->assignHeader();
        }

        $response = new Response();

        if (!is_array($body) && $body != null) {
            $body = [$body];
        }

        /** Filling up PSR-7 request */
        $response->getBody()->write(json_encode($body));
        $response->withStatus($code);

        return $response;
    }

    /**
     * @param int $errno The first parameter, errno, contains the level of the error raised, as an integer.
     * @param string $errstr The second parameter, errstr, contains the error message, as a string.
     * @param string $errfile The third parameter is optional, errfile, which contains the filename that the error was raised in, as a string.
     * @param int $errline The fourth parameter is optional, errline, which contains the line number the error was raised at, as an integer.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline)
    {
        $response = new Response();

        switch ($errno) {
            case E_USER_ERROR:
                exit($this->build([
                    'errno' => $errno,
                    'error' => $errstr,
                    'file' => $errfile,
                    'line' => $errline,
                ])->getBody());

            default:
            case E_USER_NOTICE:
            case E_USER_WARNING:
                echo $this->build([
                    'errno' => $errno,
                    'error' => $errstr,
                    'file' => $errfile,
                    'line' => $errline,
                ])->getBody();
                break;
        }

        if(CHIVEN_ENV != 'test')
            return false;
    }
}