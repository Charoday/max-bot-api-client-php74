<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

/**
 * Represents the different actions a bot can send to a chat to indicate its status.
 */
final class SenderAction
{
    const TypingOn = 'typing_on';
    const SendingPhoto = 'sending_photo';
    const SendingVideo = 'sending_video';
    const SendingAudio = 'sending_audio';
    const SendingFile = 'sending_file';
    const MarkSeen = 'mark_seen';

    private function __construct() {}
}
