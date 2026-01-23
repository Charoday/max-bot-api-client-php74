<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Buttons;

use Charoday\MaxMessengerBot\Enums\InlineButtonType;
use Charoday\MaxMessengerBot\Enums\Intent;

/**
 * Represents a button that opens a third-party application.
 */
class OpenAppButton extends AbstractButton
{
    /**
     * @var string Button text.
     */
    public $text;

    /**
     * @var string Application ID.
     */
    public $appId;

    /**
     * @var string|null Payload to pass to the app.
     */
    public $payload;

    /**
     * @var string Intent of the button.
     */
    public $intent;

    /**
     * OpenAppButton constructor.
     *
     * @param string $text
     * @param string $appId
     * @param string|null $payload
     * @param string $intent
     */
    public function __construct($text, $appId, $payload = null, $intent = Intent::Default)
    {
        parent::__construct(InlineButtonType::OpenApp);
        $this->text = $text;
        $this->appId = $appId;
        $this->payload = $payload;
        $this->intent = $intent;
    }
}
