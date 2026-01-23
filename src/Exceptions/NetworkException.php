<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Exceptions;

use Exception;

/**
 * Thrown for network-related issues like timeouts, DNS failures, or connection errors.
 */
class NetworkException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
