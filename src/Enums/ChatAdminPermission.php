<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

/**
 * Defines the permissions an administrator can have in a chat.
 */
final class ChatAdminPermission
{
    const ReadAllMessages = 'read_all_messages';
    const AddRemoveMembers = 'add_remove_members';
    const AddAdmins = 'add_admins';
    const ChangeChatInfo = 'change_chat_info';
    const PinMessage = 'pin_message';
    const Write = 'write';
    const EditLink = 'edit_link';

    private function __construct() {}
}
