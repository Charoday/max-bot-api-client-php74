<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

use Charoday\MaxMessengerBot\Enums\MessageLinkType;

/**
 * Represents a link to another message.
 */
class MessageLink extends AbstractModel
{
    /**
     * @var string Type of the link.
     */
    public $type;

    /**
     * @var string Message ID being linked.
     */
    public $mid;

    /**
     * @var int|null Chat ID where the linked message is located.
     */
    public $chatId;

    /**
     * MessageLink constructor.
     *
     * @param string $type
     * @param string $mid
     * @param int|null $chatId
     */
    public function __construct($type, $mid, $chatId = null)
    {
        $this->type = $type;
        $this->mid = $mid;
        $this->chatId = $chatId;
    }
}
