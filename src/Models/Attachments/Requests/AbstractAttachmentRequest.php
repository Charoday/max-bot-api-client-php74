<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Requests;

use Charoday\MaxMessengerBot\Models\AbstractModel;

/**
 * Base class for attachment request models used when sending messages.
 */
abstract class AbstractAttachmentRequest extends AbstractModel
{
    /**
     * @var string The type of the attachment.
     */
    public $type;

    /**
     * @var object The payload object containing type-specific fields.
     */
    public $payload;

    /**
     * AbstractAttachmentRequest constructor.
     *
     * @param string $type
     * @param object $payload
     */
    public function __construct($type, $payload)
    {
        $this->type = $type;
        $this->payload = $payload;
    }

    /**
     * Converts the model to an array for JSON serialization.
     * Ensures the structure is: { "type": "...", "payload": { ... } }
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            'type' => $this->type,
            'payload' => $this->payload instanceof AbstractModel
                ? $this->payload->toArray()
                : (array)$this->payload,
        ];
    }
}
