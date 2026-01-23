<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a user stops the bot.
 */
class BotStoppedUpdate extends AbstractUpdate
{
    /**
     * @var int User ID who stopped the bot.
     */
    public $userId;

    /**
     * BotStoppedUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param int $userId
     */
    public function __construct($mid, $time, $marker, $userId)
    {
        parent::__construct($mid, $time, $marker);
        $this->userId = $userId;
    }
}
