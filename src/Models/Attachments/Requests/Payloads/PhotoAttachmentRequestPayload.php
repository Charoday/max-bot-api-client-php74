<?php

declare(strict_types=1);

namespace Charoday\MaxMessengerBot\Models\Attachments\Requests\Payloads;

use InvalidArgumentException;

class PhotoAttachmentRequestPayload extends AbstractAttachmentRequestPayload
{
    public $url;
    public $token;

    public function __construct($url = null, $token = null)
    {
        if ($url === null && $token === null) {
            throw new InvalidArgumentException(
                'Provide one of "url" or "token" for PhotoAttachmentRequestPayload.'
            );
        }
        $this->url = $url;
        $this->token = $token;
    }
}
