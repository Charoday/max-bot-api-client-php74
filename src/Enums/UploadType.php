<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

final class UploadType
{
    const Image = 'image';
    const Video = 'video';
    const Audio = 'audio';
    const File = 'file';

    private function __construct() {}
}
