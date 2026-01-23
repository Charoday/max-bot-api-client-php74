<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Exceptions;

use LogicException;

/**
 * Thrown when a security check fails, such as webhook signature verification.
 */
class SecurityException extends LogicException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
