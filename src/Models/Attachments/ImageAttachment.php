<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents an image attachment in a message.
 */
class ImageAttachment extends AbstractAttachment
{
    /**
     * @var string Token for the image.
     */
    public $token;

    /**
     * @var int Уникальный ID этого изображения
     */
    public $photoId;

    /**
     * @var string|null Direct URL to the image.
     */
    public $url;

    /**
     * ImageAttachment constructor.
     *
     * @param string $token
     * @param string|null $url
     * @param int $photoId
     */
    public function __construct($token, $url = null, $photoId = 0)
    {
        parent::__construct(AttachmentType::Image);
        $this->token = $token;
        $this->url = $url;
        $this->photoId = $photoId;
    }
}
