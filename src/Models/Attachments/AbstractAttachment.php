<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Models\AbstractModel;

/**
 * Base class for all attachment types in messages.
 */
abstract class AbstractAttachment extends AbstractModel
{
    /**
     * @var string The type of the attachment.
     */
    public $type;

    /**
     * AbstractAttachment constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }
}
