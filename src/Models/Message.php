<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

use Charoday\MaxMessengerBot\Models\Attachments\AbstractAttachment;

/**
 * Represents a message in a chat.
 */
class Message extends AbstractModel
{
    /**
     * @var string Message ID.
     */
    public $mid;

    /**
     * @var int Timestamp when the message was sent.
     */
    public $time;

    /**
     * @var string Message text content.
     */
    public $text;

    /**
     * @var string|null Format of the message text.
     */
    public $format;

    /**
     * @var MessageLink|null Link to another message.
     */
    public $link;

    /**
     * @var AbstractAttachment[]|null List of attachments.
     */
    public $attachments;

    /**
     * @var bool Whether participants should be notified.
     */
    public $notify;

    /**
     * @var User|null Sender of the message.
     */
    public $sender;

    /**
     * @var Chat|null Chat where the message was sent.
     */
    public $chat;

    /**
     * Message constructor.
     *
     * @param string $mid
     * @param int $time
     * @param string $text
     * @param string|null $format
     * @param MessageLink|null $link
     * @param AbstractAttachment[]|null $attachments
     * @param bool $notify
     * @param User|null $sender
     * @param Chat|null $chat
     */
    public function __construct($mid, $time, $text, $format = null, $link = null, $attachments = null, $notify = true, $sender = null, $chat = null)
    {
        $this->mid = $mid;
        $this->time = $time;
        $this->text = $text;
        $this->format = $format;
        $this->link = $link;
        $this->attachments = $attachments;
        $this->notify = $notify;
        $this->sender = $sender;
        $this->chat = $chat;
    }
}
