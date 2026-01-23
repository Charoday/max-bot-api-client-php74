<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

/**
 * Defines the types of attachments that can be sent or received in messages.
 */
final class AttachmentType
{
    const Image = 'image';
    const Video = 'video';
    const Audio = 'audio';
    const File = 'file';
    const Sticker = 'sticker';
    const Contact = 'contact';
    const InlineKeyboard = 'inline_keyboard';
    const ReplyKeyboard = 'reply_keyboard';
    const Location = 'location';
    const Share = 'share';
    const Data = 'data';

    private function __construct() {}
}
