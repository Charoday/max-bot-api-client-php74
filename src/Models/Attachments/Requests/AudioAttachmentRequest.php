<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Requests;

use Charoday\MaxMessengerBot\Enums\AttachmentType;
use Charoday\MaxMessengerBot\Models\Attachments\Payloads\UploadedInfoAttachmentRequestPayload;

/**
 * Request model for audio attachments when sending messages.
 */
class AudioAttachmentRequest extends AbstractAttachmentRequest
{
    public static function fromToken($token)
    {
        return new self(new UploadedInfoAttachmentRequestPayload($token));
    }

    private function __construct($payload)
    {
        parent::__construct(AttachmentType::Audio, $payload);
    }
}
