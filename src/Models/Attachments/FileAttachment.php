<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a file attachment in a message.
 */
class FileAttachment extends AbstractAttachment
{
    /**
     * @var string Token for the file.
     */
    public $token;

    /**
     * @var string Original filename.
     */
    public $name;

    /**
     * @var int Size of the file in bytes.
     */
    public $size;

    /**
     * @var string|null Direct URL to the file.
     */
    public $url;

    /**
     * FileAttachment constructor.
     *
     * @param string $token
     * @param string|null $url
     * @param string $filename
     * @param int $size
     */
    public function __construct($token, $url = null, $filename = '', $size = 0)
    {
        parent::__construct(AttachmentType::File);
        $this->token = $token;
        $this->url = $url;
        $this->name = $filename;
        $this->size = $size;
    }
}
