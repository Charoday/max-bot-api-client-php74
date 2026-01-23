<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a message is removed.
 */
class MessageRemovedUpdate extends AbstractUpdate
{
    /**
     * @var string Message ID that was removed.
     */
    public $mid;

    /**
     * @var int Chat ID where the message was removed.
     */
    public $chatId;

    /**
     * MessageRemovedUpdate constructor.
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
