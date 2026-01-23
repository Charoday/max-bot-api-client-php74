<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a user starts the bot.
 */
class BotStartedUpdate extends AbstractUpdate
{
    /**
     * @var int User ID who started the bot.
     */
    public $userId;

    /**
     * BotStartedUpdate constructor.
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
