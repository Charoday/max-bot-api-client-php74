<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a data attachment in a message.
 */
class DataAttachment extends AbstractAttachment
{
    /**
     * @var string Raw data content.
     */
    public $data;

    /**
     * DataAttachment constructor.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        parent::__construct(AttachmentType::Data);
        $this->data = $data;
    }
}
