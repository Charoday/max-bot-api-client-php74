<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when an attachment is not ready for use (e.g., still processing).
 */
class AttachmentNotReadyException extends ClientApiException
{
    public function __construct($message = "", $code = 0, ResponseInterface $response = null, $httpStatusCode = null)
    {
        parent::__construct($message, $code, $response, $httpStatusCode);
    }
}
