<?php

declare(strict_types=1);

namespace Charoday\MaxMessengerBot\Models\Attachments\Requests\Payloads;

use Charoday\MaxMessengerBot\Models\Attachments\Buttons\AbstractButton;

class InlineKeyboardAttachmentRequestPayload extends AbstractAttachmentRequestPayload
{
    public $buttons;

    public function __construct($buttons)
    {
        $this->buttons = $buttons;
    }
}
