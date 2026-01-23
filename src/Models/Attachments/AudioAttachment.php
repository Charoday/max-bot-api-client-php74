<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents an audio attachment in a message.
 */
class AudioAttachment extends AbstractAttachment
{
    /**
     * @var string Token for the audio file.
     */
    public $token;

    /**
     * @var int Duration of the audio in seconds.
     */
    public $duration;

    /**
     * @var int Size of the audio file in bytes.
     */
    public $size;

    /**
     * @var string|null Direct URL to the audio file.
     */
    public $url;

    /**
     * AudioAttachment constructor.
     *
     * @param string $token
     * @param int $duration
     * @param int $size
     * @param string|null $url
     */
    public function __construct($token, $duration, $size, $url = null)
    {
        parent::__construct(AttachmentType::Audio);
        $this->token = $token;
        $this->duration = $duration;
        $this->size = $size;
        $this->url = $url;
    }
}
