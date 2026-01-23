<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Buttons;

use Charoday\MaxMessengerBot\Enums\InlineButtonType;
use Charoday\MaxMessengerBot\Enums\Intent;

/**
 * Represents a callback button that sends a payload back to the bot.
 */
class CallbackButton extends AbstractButton
{
    /**
     * @var string Button text.
     */
    public $text;

    /**
     * @var string|null Payload to send when clicked.
     */
    public $payload;

    /**
     * @var string Intent of the button.
     */
    public $intent;

    /**
     * CallbackButton constructor.
     *
     * @param string $text
     * @param string|null $payload
     * @param string $intent
     */
    public function __construct($text, $payload = null, $intent = Intent::Default)
    {
        parent::__construct(InlineButtonType::Callback);
        $this->text = $text;
        $this->payload = $payload;
        $this->intent = $intent;
    }
}
