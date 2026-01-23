<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

use Charoday\MaxMessengerBot\Models\Message;

/**
 * Represents an update when a message is edited.
 */
class MessageEditedUpdate extends AbstractUpdate
{
    /**
     * @var Message The edited message.
     */
    public $message;

    /**
     * MessageEditedUpdate constructor.
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
