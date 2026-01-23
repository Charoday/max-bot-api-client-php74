<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Buttons;

use Charoday\MaxMessengerBot\Enums\InlineButtonType;
use Charoday\MaxMessengerBot\Enums\Intent;

/**
 * Represents a button that opens a specific chat.
 */
class ChatButton extends AbstractButton
{
    /**
     * @var string Button text.
     */
    public $text;

    /**
     * @var int Chat ID to open.
     */
    public $chatId;

    /**
     * @var string Intent of the button.
     */
    public $intent;

    /**
     * ChatButton constructor.
     *
     * @param string $text
     * @param int $chatId
     * @param string $intent
     */
    public function __construct($text, $chatId, $intent = Intent::Default)
    {
        parent::__construct(InlineButtonType::Chat);
        $this->text = $text;
        $this->chatId = $chatId;
        $this->intent = $intent;
    }
}
