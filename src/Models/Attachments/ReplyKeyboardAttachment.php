<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Models\Attachments\Buttons\AbstractButton;
use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a reply keyboard attachment in a message.
 */
class ReplyKeyboardAttachment extends AbstractAttachment
{
    /**
     * @var AbstractButton[][] Array of button rows.
     */
    public $buttons;

    /**
     * @var bool Whether to resize the keyboard.
     */
    public $resizeKeyboard;

    /**
     * @var bool Whether to hide the keyboard after use.
     */
    public $oneTimeKeyboard;

    /**
     * ReplyKeyboardAttachment constructor.
     *
     * @param AbstractButton[][] $buttons
     * @param bool $resizeKeyboard
     * @param bool $oneTimeKeyboard
     */
    public function __construct($buttons, $resizeKeyboard, $oneTimeKeyboard)
    {
        parent::__construct(AttachmentType::ReplyKeyboard);
        $this->buttons = $buttons;
        $this->resizeKeyboard = $resizeKeyboard;
        $this->oneTimeKeyboard = $oneTimeKeyboard;
    }
}
