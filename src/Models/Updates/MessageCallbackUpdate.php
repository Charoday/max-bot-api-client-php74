<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a user clicks an inline button.
 */
class MessageCallbackUpdate extends AbstractUpdate
{
    /**
     * @var string Callback ID for responding to the button click.
     */
    public $callbackId;

    /**
     * @var int User ID who clicked the button.
     */
    public $userId;

    /**
     * @var int Chat ID where the message is located.
     */
    public $chatId;

    /**
     * @var string|null Payload sent with the button.
     */
    public $payload;

    /**
     * MessageCallbackUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param string $callbackId
     * @param int $userId
     * @param int $chatId
     * @param string|null $payload
     */
    public function __construct($mid, $time, $marker, $callbackId, $userId, $chatId, $payload = null)
    {
        parent::__construct($mid, $time, $marker);
        $this->callbackId = $callbackId;
        $this->userId = $userId;
        $this->chatId = $chatId;
        $this->payload = $payload;
    }
}
