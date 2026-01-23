<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot;
use Charoday\MaxMessengerBot\Exceptions\AttachmentNotReadyException;
use Charoday\MaxMessengerBot\Exceptions\ForbiddenException;
use Charoday\MaxMessengerBot\Exceptions\ClientApiException;
use Charoday\MaxMessengerBot\Exceptions\MethodNotAllowedException;
use Charoday\MaxMessengerBot\Exceptions\NetworkException;
use Charoday\MaxMessengerBot\Exceptions\NotFoundException;
use Charoday\MaxMessengerBot\Exceptions\RateLimitExceededException;
use Charoday\MaxMessengerBot\Exceptions\SerializationException;
use Charoday\MaxMessengerBot\Exceptions\UnauthorizedException;
use InvalidArgumentException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use RuntimeException;
/**
* The low-level HTTP client responsible for communicating with the Max Bot API.
* It handles request signing, error handling, and JSON serialization/deserialization.
* This class is an abstraction over any PSR-18 compatible HTTP client.
*/
class Client implements ClientApiInterface
{
    private $accessToken;
    private $httpClient;
    private $requestFactory;
    private $streamFactory;
    private $baseUrl;
    private $apiVersion;
    private $logger;

    /**
    * @param string $accessToken Your bot's access token from @MasterBot.
    * @param ClientInterface $httpClient A PSR-18 compatible HTTP client (e.g., Guzzle).
    * @param RequestFactoryInterface $requestFactory A PSR-17 factory for creating requests.
    * @param StreamFactoryInterface $streamFactory A PSR-17 factory for creating request body streams.
    * @param string $baseUrl The base URL for API requests.
    * @param string|null $apiVersion The API version to use for requests.
    * @param LoggerInterface $logger
    *
    * @throws InvalidArgumentException
    */
    public function __construct(
        $accessToken,
        $httpClient,
        $requestFactory,
        $streamFactory,
        $baseUrl,
        $apiVersion = null,
        $logger = null
    ) {
        if (empty($accessToken)) {
            throw new InvalidArgumentException('Access token cannot be empty.');
        }
        $this->accessToken = $accessToken;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->baseUrl = $baseUrl;
        $this->apiVersion = $apiVersion;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
    * @inheritDoc
    */
    public function request($method, $uri, $queryParams = [], $body = [])
    {
        if (!empty($this->apiVersion)) {
            $queryParams['v'] = $this->apiVersion;
        }
        $this->logger->debug('Sending API request', [
            'method' => $method,
            'url' => $this->baseUrl . $uri,
            'body' => $body,
        ]);

        $fullUrl = $this->baseUrl . $uri . '?' . http_build_query($queryParams);
        $request = $this->requestFactory
            ->createRequest($method, $fullUrl)
            ->withHeader('Authorization', $this->accessToken);
        if (!empty($body)) {
            try {
                $payload = json_encode($body, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new SerializationException('Failed to encode request body to JSON.', 0, $e);
            }
            $stream = $this->streamFactory->createStream($payload);
            $request = $request
                ->withBody($stream)
                ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }
        try {
            $response = $this->httpClient->sendRequest($request);
            //var_dump($response);
        } catch (ClientExceptionInterface $e) {
            // This catches network errors, DNS failures, timeouts, etc.
            $this->logger->error('Network exception during API request', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            throw new NetworkException($e->getMessage(), $e->getCode(), $e);
        }
        $this->handleErrorResponse($response);
        $responseBody = (string)$response->getBody();
        $this->logger->debug('Received API response', [
            'status' => $response->getStatusCode(),
            'body' => $responseBody,
        ]);
        // Handle successful but empty responses (e.g., from DELETE endpoints)
        if (empty($responseBody)) {
            // The API spec often returns {"success": true}, so we can simulate that
            // for consistency if the body is truly empty.
            return ['success' => true];
        }
        try {
            return json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new SerializationException('Failed to decode API response JSON.', 0, $e);
        }
    }

    /**
    * @inheritDoc
    */
    public function multipartUpload($uri, $fileContents, $fileName)
    {
        $boundary = '--------------------------' . microtime(true);
        $bodyStream = $this->streamFactory->createStream();
        $bodyStream->write("--$boundary\r\n");
        $bodyStream->write("Content-Disposition: form-data; name=\"data\"; filename=\"{$fileName}\"\r\n");
        $bodyStream->write("Content-Type: application/octet-stream\r\n\r\n");
        if (is_resource($fileContents)) {
            $bodyStream->write((string)stream_get_contents($fileContents));
        } else {
            $bodyStream->write((string)$fileContents);
        }
        $bodyStream->write("\r\n");
        $bodyStream->write("--$boundary--\r\n");
        $request = $this->requestFactory
            ->createRequest('POST', $uri)
            ->withHeader('Content-Type', 'multipart/form-data; boundary=' . $boundary)
            ->withHeader('Authorization', $this->accessToken)
            ->withBody($bodyStream);
        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new NetworkException($e->getMessage(), $e->getCode(), $e);
        }
        $this->handleErrorResponse($response);
        return (string)$response->getBody();
    }

    /**
    * @inheritDoc
    */
    public function resumableUpload($uploadUrl, $fileResource, $fileName, $fileSize, $chunkSize = 1048576)
    {
        if (!is_resource($fileResource) || get_resource_type($fileResource) !== 'stream') {
            throw new InvalidArgumentException('fileResource must be a valid stream resource.');
        }
        // @phpstan-ignore-next-line
        if ($fileSize <= 0) {
            throw new InvalidArgumentException('File size must be greater than 0.');
        }
        $startByte = 0;
        $finalResponseBody = '';
        while (!feof($fileResource)) {
            $chunk = fread($fileResource, $chunkSize);
            if ($chunk === false) {
                // @codeCoverageIgnoreStart
                throw new RuntimeException('Failed to read chunk from file stream.');
                // @codeCoverageIgnoreEnd
            }
            $chunkLength = mb_strlen($chunk);
            if ($chunkLength === 0) {
                break;
            }
            $endByte = $startByte + $chunkLength - 1;
            $chunkStream = $this->streamFactory->createStream($chunk);
            $request = $this->requestFactory->createRequest('POST', $uploadUrl)
                ->withBody($chunkStream)
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                ->withHeader('Content-Range', "bytes {$startByte}-{$endByte}/{$fileSize}")
                ->withHeader('Authorization', $this->accessToken);
            try {
                $response = $this->httpClient->sendRequest($request);
            } catch (ClientExceptionInterface $e) {
                throw new NetworkException($e->getMessage(), $e->getCode(), $e);
            }
            $this->handleErrorResponse($response);
            // The final response might contain the retval
            $finalResponseBody = (string)$response->getBody();
            $startByte += $chunkLength;
        }
        // According to docs, for video/audio the token is sent separately,
        // and the upload response contains 'retval'. We return the body of the last response.
        return $finalResponseBody;
    }

    /**
    * Checks the response for an error status code and throws a corresponding typed exception.
    *
    * @throws ClientApiException
    */
    private function handleErrorResponse(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        // 2xx codes are considered successful.
        if ($statusCode >= 200 && $statusCode < 300) {
            return;
        }
        $responseBody = (string)$response->getBody();
        $data = json_decode($responseBody, true) ?? [];
        $errorCode = $data['code'] ?? 'unknown';
        $errorMessage = $data['message'] ?? 'An unknown error occurred.';
        $this->logger->error('API error response received', [
            'status' => $statusCode,
            'body' => $responseBody,
        ]);
        switch ($statusCode) {
            case 401:
                throw new UnauthorizedException($errorMessage, $errorCode, $response);
            case 403:
                throw new ForbiddenException($errorMessage, $errorCode, $response);
            case 404:
                throw new NotFoundException($errorMessage, $errorCode, $response);
            case 405:
                throw new MethodNotAllowedException($errorMessage, $errorCode, $response);
            case 429:
                throw new RateLimitExceededException($errorMessage, $errorCode, $response);
            default:
                throw $this->mapErrorCodeToException($errorMessage, $errorCode, $response, $statusCode);
        }
    }

    /**
    * @param string $message
    * @param string $errorCode
    * @param ResponseInterface $response
    * @param int|null $httpStatusCode
    *
    * @return ClientApiException
    */
    private function mapErrorCodeToException($message, $errorCode, $response, $httpStatusCode = null)
    {
        switch ($errorCode) {
            case 'attachment.not.ready':
                return new AttachmentNotReadyException($message, $errorCode, $response, $httpStatusCode);
            default:
                return new ClientApiException($message, $errorCode, $response, $httpStatusCode);
        }
    }
}
