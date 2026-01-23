<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

final class ChatStatus
{
    const Active = 'active';
    const Removed = 'removed';
    const Left = 'left';
    const Closed = 'closed';
    const Suspended = 'suspended';

    private function __construct() {}
}
