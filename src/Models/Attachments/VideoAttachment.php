<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a video attachment in a message.
 */
class VideoAttachment extends AbstractAttachment
{
    /**
     * @var string Token for the video.
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
     * @var string|null Direct URL to the video.
     */
    public $url;
    
    /**
     * @var string|null Direct URL to the video.
     */
    public $thumbnailUrl;

    public function __construct($token, $url = null, $thumbnailUrl = null, $width = null, $height = null, $duration = null)
    {
        parent::__construct(AttachmentType::Video);
        $this->token = $token;
        $this->url = $url;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->width = $width;
        $this->height = $height;
        $this->duration = $duration;
    }
}
