<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Exceptions;

use LogicException;

/**
 * Thrown when there is an error during JSON encoding or decoding.
 */
class SerializationException extends LogicException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
