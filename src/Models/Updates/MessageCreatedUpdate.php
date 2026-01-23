<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

use Charoday\MaxMessengerBot\Models\Message;

/**
 * Represents an update when a new message is created.
 */
class MessageCreatedUpdate extends AbstractUpdate
{
    /**
     * @var Message The message that was created.
     */
    public $message;

    /**
     * MessageCreatedUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param Message $message
     */
    public function __construct($mid, $time, $marker, $message)
    {
        parent::__construct($mid, $time, $marker);
        $this->message = $message;
    }
}
