<?php

declare(strict_types=1);

namespace Charoday\MaxMessengerBot\Models\Attachments\Requests\Payloads;

class UploadedInfoAttachmentRequestPayload extends AbstractAttachmentRequestPayload
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }
}
