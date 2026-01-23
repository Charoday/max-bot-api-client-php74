<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * The base exception for all API-level errors returned by the Max Bot API.
 */
class ClientApiException extends Exception
{
    /**
     * @var string The internal error code from the API.
     */
    public $errorCode;

    /**
     * @var ResponseInterface|null The full HTTP response that caused this exception.
     */
    public $response;

    /**
     * @var int|null The HTTP status code of the response.
     */
    public $httpStatusCode;

    public function __construct($message = "", $errorCode = "", ResponseInterface $response = null, $httpStatusCode = null)
    {
        parent::__construct($message, 0);
        $this->errorCode = $errorCode;
        $this->response = $response;
        $this->httpStatusCode = $httpStatusCode;
    }
}
