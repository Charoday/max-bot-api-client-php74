<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when the bot is added to a chat.
 */
class BotAddedUpdate extends AbstractUpdate
{
    /**
     * @var int Chat ID where the bot was added.
     */
    public $chatId;

    /**
     * @var int User ID who added the bot.
     */
    public $userId;

    /**
     * BotAddedUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param int $chatId
     * @param int $userId
     */
    public function __construct($mid, $time, $marker, $chatId, $userId)
    {
        parent::__construct($mid, $time, $marker);
        $this->chatId = $chatId;
        $this->userId = $userId;
    }
}
