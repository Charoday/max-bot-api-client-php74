<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Buttons;

use Charoday\MaxMessengerBot\Enums\InlineButtonType;
use Charoday\MaxMessengerBot\Enums\Intent;

/**
 * Represents a button that sends a predefined message.
 */
class MessageButton extends AbstractButton
{
    /**
     * @var string Button text.
     */
    public $text;

    /**
     * @var string Intent of the button.
     */
    public $intent;

    /**
     * MessageButton constructor.
     *
     * @param string $text
     * @param string $intent
     */
    public function __construct($text, $intent = Intent::Default)
    {
        parent::__construct(InlineButtonType::Message);
        $this->text = $text;
        $this->intent = $intent;
    }
}
