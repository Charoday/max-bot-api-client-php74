<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents an upload endpoint returned by the API.
 */
class UploadEndpoint extends AbstractModel
{
    /**
     * @var string URL to upload the file to.
     */
    public $url;

    /**
     * @var string|null Token for the upload (for audio/video).
     */
    public $token;

    /**
     * UploadEndpoint constructor.
     *
     * @param string $url
     * @param string|null $token
     */
    public function __construct($url, $token = null)
    {
        $this->url = $url;
        $this->token = $token;
    }
}
