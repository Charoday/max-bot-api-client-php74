<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when the bot is removed from a chat.
 */
class BotRemovedUpdate extends AbstractUpdate
{
    /**
     * @var int Chat ID where the bot was removed.
     */
    public $chatId;

    /**
     * @var int User ID who removed the bot.
     */
    public $userId;

    /**
     * BotRemovedUpdate constructor.
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
