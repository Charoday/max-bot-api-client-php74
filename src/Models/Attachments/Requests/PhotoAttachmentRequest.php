<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Requests;

use Charoday\MaxMessengerBot\Enums\AttachmentType;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\Payloads\PhotoAttachmentRequestPayload;

/**
 * Request model for photo attachments when sending messages.
 */
class PhotoAttachmentRequest extends AbstractAttachmentRequest
{
    public static function fromToken($token)
    {
        return new self(new PhotoAttachmentRequestPayload(null, $token));
    }

    public static function fromUrl($url)
    {
        return new self(new PhotoAttachmentRequestPayload($url, null));
    }

    private function __construct($payload)
    {
        parent::__construct(AttachmentType::Image, $payload);
    }

    
}
