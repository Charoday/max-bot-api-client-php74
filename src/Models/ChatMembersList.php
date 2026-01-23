<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a paginated list of chat members.
 */
class ChatMembersList extends AbstractModel
{
    /**
     * @var ChatMember[] List of chat members.
     */
    public $members;

    /**
     * @var int|null Marker for pagination.
     */
    public $marker;

    /**
     * ChatMembersList constructor.
     *
     * @param ChatMember[] $members
     * @param int|null $marker
     */
    public function __construct($members, $marker = null)
    {
        $this->members = $members;
        $this->marker = $marker;
    }
}
