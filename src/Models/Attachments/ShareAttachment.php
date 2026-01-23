<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a share attachment in a message.
 */
class ShareAttachment extends AbstractAttachment
{
    /**
     * @var string Title of the shared content.
     */
    public $title;

    /**
     * @var string Description of the shared content.
     */
    public $description;

    /**
     * @var string URL of the shared content.
     */
    public $url;

    /**
     * @var string|null Preview image URL.
     */
    public $image;

    /**
     * ShareAttachment constructor.
     *
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string|null $image
     */
    public function __construct($title, $description, $url, $image = null)
    {
        parent::__construct(AttachmentType::Share);
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->image = $image;
    }
}
