<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a chat member.
 */
class ChatMember extends AbstractModel
{
    /**
     * @var int User ID of the member.
     */
    public $userId;

    /**
     * @var int Timestamp when the user joined the chat.
     */
    public $joinedAt;

    /**
     * @var string[]|null List of permissions if the member is an admin.
     */
    public $permissions;

    /**
     * @var bool Whether the member is the owner of the chat.
     */
    public $isOwner;

    /**
     * ChatMember constructor.
     *
     * @param int $userId
     * @param int $joinedAt
     * @param string[]|null $permissions
     * @param bool $isOwner
     */
    public function __construct($userId, $joinedAt, $permissions = null, $isOwner = false)
    {
        $this->userId = $userId;
        $this->joinedAt = $joinedAt;
        $this->permissions = $permissions;
        $this->isOwner = $isOwner;
    }
}
