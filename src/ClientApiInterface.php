<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot;

/**
* An interface for the low-level HTTP client that interacts with the Max Bot API.
* This allows you to swap out the underlying HTTP implementation (e.g., Guzzle, cURL).
*/
interface ClientApiInterface
{
    /**
    * Sends a generic request to the Max Bot API.
    *
    * @param string $method The HTTP method (GET, POST, etc.).
    * @param string $uri The API endpoint URI.
    * @param array<string, mixed> $queryParams Query parameters to be appended to the URL.
    * @param array<string, mixed> $body The JSON-serializable request body.
    *
    * @return array<string, mixed> The decoded JSON response from the API.
    */
    public function request($method, $uri, $queryParams = [], $body = []);

    /**
    * Uploads a file using a simple multipart/form-data request.
    *
    * @param string $uri The full upload URL provided by the API.
    * @param resource|string $fileContents The file contents as a stream resource or string.
    * @param string $fileName The desired filename for the upload.
    *
    * @return string The raw response body from the upload server.
    */
    public function multipartUpload($uri, $fileContents, $fileName);

    /**
    * Uploads a large file using the resumable upload protocol (chunked uploads).
    *
    * @param string $uploadUrl The full upload URL provided by the API.
    * @param resource $fileResource A stream resource pointing to the file to upload.
    * @param string $fileName The desired filename for the upload.
    * @param int $fileSize The total size of the file in bytes.
    * @param int $chunkSize The size of each chunk in bytes (default: 1MB).
    *
    * @return string The raw response body from the final upload chunk.
    */
    public function resumableUpload($uploadUrl, $fileResource, $fileName, $fileSize, $chunkSize = 1048576);
}
