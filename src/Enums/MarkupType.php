<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

final class MarkupType
{
    const Strong = 'strong';
    const Emphasized = 'emphasized';
    const Monospaced = 'monospaced';
    const Link = 'link';
    const Strikethrough = 'strikethrough';
    const Underline = 'underline';
    const UserMention = 'user_mention';
    const Heading = 'heading';
    const Highlighted = 'highlighted';

    private function __construct() {}
}
