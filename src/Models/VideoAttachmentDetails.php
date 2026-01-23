<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents detailed information about a video attachment.
 */
class VideoAttachmentDetails extends AbstractModel
{
    /**
     * @var string Token of the video.
     */
    public $token;

    /**
     * @var int Width of the video in pixels.
     */
    public $width;

    /**
     * @var int Height of the video in pixels.
     */
    public $height;

    /**
     * @var int Duration of the video in seconds.
     */
    public $duration;

    /**
     * @var int Size of the video file in bytes.
     */
    public $size;

    /**
     * @var string Direct URL to the video.
     */
    public $url;

    /**
     * @var string|null Preview image URL.
     */
    public $previewUrl;

    /**
     * @var string[] List of playback URLs.
     */
    public $playbackUrls;

    /**
     * VideoAttachmentDetails constructor.
     *
     * @param string $token
     * @param int $width
     * @param int $height
     * @param int $duration
     * @param int $size
     * @param string $url
     * @param string|null $previewUrl
     * @param string[] $playbackUrls
     */
    public function __construct($token, $width, $height, $duration, $size, $url, $previewUrl = null, $playbackUrls = [])
    {
        $this->token = $token;
        $this->width = $width;
        $this->height = $height;
        $this->duration = $duration;
        $this->size = $size;
        $this->url = $url;
        $this->previewUrl = $previewUrl;
        $this->playbackUrls = $playbackUrls;
    }
}
