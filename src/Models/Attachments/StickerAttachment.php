<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a sticker attachment in a message.
 */
class StickerAttachment extends AbstractAttachment
{
    /**
     * @var string Token for the sticker.
     */
    public $token;

    /**
     * @var int Width of the sticker in pixels.
     */
    public $width;

    /**
     * @var int Height of the sticker in pixels.
     */
    public $height;

    /**
     * @var int Size of the sticker file in bytes.
     */
    public $size;

    /**
     * @var string|null Direct URL to the sticker.
     */
    public $url;

    /**
     * StickerAttachment constructor.
     *
     * @param string $token
     * @param int $width
     * @param int $height
     * @param int $size
     * @param string|null $url
     */
    public function __construct($token, $width, $height, $size, $url = null)
    {
        parent::__construct(AttachmentType::Sticker);
        $this->token = $token;
        $this->width = $width;
        $this->height = $height;
        $this->size = $size;
        $this->url = $url;
    }
}
