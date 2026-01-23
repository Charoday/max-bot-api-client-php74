<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when the API rate limit has been exceeded (HTTP 429).
 */
class RateLimitExceededException extends ClientApiException
{
    public function __construct($message = "", $code = 0, ResponseInterface $response = null, $httpStatusCode = null)
    {
        parent::__construct($message, $code, $response, $httpStatusCode);
    }
}
