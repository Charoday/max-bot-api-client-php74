<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a message chat is created.
 */
class MessageChatCreatedUpdate extends AbstractUpdate
{
    /**
     * @var int Chat ID that was created.
     */
    public $chatId;

    /**
     * MessageChatCreatedUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param int $chatId
     */
    public function __construct($mid, $time, $marker, $chatId)
    {
        parent::__construct($mid, $time, $marker);
        $this->chatId = $chatId;
    }
}
