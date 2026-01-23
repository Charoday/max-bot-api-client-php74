<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Models\Attachments\Buttons\AbstractButton;
use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents an inline keyboard attachment in a message.
 */
class InlineKeyboardAttachment extends AbstractAttachment
{
    /**
     * @var AbstractButton[][] Array of button rows.
     */
    public $buttons;

    /**
     * InlineKeyboardAttachment constructor.
     *
     * @param AbstractButton[][] $buttons
     */
    public function __construct($buttons)
    {
        parent::__construct(AttachmentType::InlineKeyboard);
        $this->buttons = $buttons;
    }

    /**
     * Converts the model to an array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            'type' => $this->type,
            'payload' => [
                'buttons' => array_map(function ($row) {
                    return array_map(function ($button) {
                        return $button->toArray();
                    }, $row);
                }, $this->buttons),
            ],
        ];
    }
}
