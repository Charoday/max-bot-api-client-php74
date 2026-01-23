<?php

declare(strict_types=1);

namespace Charoday\MaxMessengerBot\Models\Attachments\Requests;

use Charoday\MaxMessengerBot\Enums\AttachmentType;
use Charoday\MaxMessengerBot\Models\Attachments\Payloads\InlineKeyboardAttachmentRequestPayload;

class InlineKeyboardAttachmentRequest extends AbstractAttachmentRequest
{
    public function __construct($buttons)
    {
        parent::__construct(
            AttachmentType::InlineKeyboard,
            new InlineKeyboardAttachmentRequestPayload($buttons)
        );
    }
}
