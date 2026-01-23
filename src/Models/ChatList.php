<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a paginated list of chats.
 */
class ChatList extends AbstractModel
{
    /**
     * @var Chat[] List of chats.
     */
    public $chats;

    /**
     * @var int|null Marker for pagination.
     */
    public $marker;

    /**
     * ChatList constructor.
     *
     * @param Chat[] $chats
     * @param int|null $marker
     */
    public function __construct($chats, $marker = null)
    {
        $this->chats = $chats;
        $this->marker = $marker;
    }
}
