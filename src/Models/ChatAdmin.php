<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a chat administrator with permissions.
 */
class ChatAdmin extends AbstractModel
{
    /**
     * @var int User ID of the administrator.
     */
    public $userId;

    /**
     * @var string[] List of permissions granted to the administrator.
     */
    public $permissions;

    /**
     * ChatAdmin constructor.
     *
     * @param int $userId
     * @param string[] $permissions
     */
    public function __construct($userId, $permissions)
    {
        $this->userId = $userId;
        $this->permissions = $permissions;
    }
}
