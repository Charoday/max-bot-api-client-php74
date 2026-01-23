<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

use Charoday\MaxMessengerBot\Enums\ChatStatus;
use Charoday\MaxMessengerBot\Enums\ChatType;

/**
 * Represents a chat (dialog, group, or channel).
 */
class Chat extends AbstractModel
{
    /**
     * @var int Chat's unique identifier.
     */
    public $id;

    /**
     * @var string Type of the chat.
     */
    public $type;

    /**
     * @var string|null Title of the chat.
     */
    public $title;

    /**
     * @var string|null Description of the chat.
     */
    public $about;

    /**
     * @var string|null URL to the chat's icon.
     */
    public $icon;

    /**
     * @var string|null Public link to the chat.
     */
    public $link;

    /**
     * @var int|null Number of members in the chat.
     */
    public $membersCount;

    /**
     * @var string|null Public link of the chat.
     */
    public $publicLink;

    /**
     * @var string Status of the chat.
     */
    public $status;

    /**
     * Chat constructor.
     *
     * @param int $id
     * @param string $type
     * @param string|null $title
     * @param string|null $about
     * @param string|null $icon
     * @param string|null $link
     * @param int|null $membersCount
     * @param string|null $publicLink
     * @param string $status
     */
    public function __construct($id, $type, $title = null, $about = null, $icon = null, $link = null, $membersCount = null, $publicLink = null, $status = ChatStatus::Active)
    {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->about = $about;
        $this->icon = $icon;
        $this->link = $link;
        $this->membersCount = $membersCount;
        $this->publicLink = $publicLink;
        $this->status = $status;
    }
}
