<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a user is removed from a chat.
 */
class UserRemovedUpdate extends AbstractUpdate
{
    /**
     * @var int Chat ID where the user was removed.
     */
    public $chatId;

    /**
     * @var int User ID who was removed.
     */
    public $userId;

    /**
     * UserRemovedUpdate constructor.
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
