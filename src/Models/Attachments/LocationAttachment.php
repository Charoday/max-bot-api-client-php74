<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a location attachment in a message.
 */
class LocationAttachment extends AbstractAttachment
{
    /**
     * @var float Latitude coordinate.
     */
    public $lat;

    /**
     * @var float Longitude coordinate.
     */
    public $lng;

    /**
     * LocationAttachment constructor.
     *
     * @param float $lat
     * @param float $lng
     */
    public function __construct($lat, $lng)
    {
        parent::__construct(AttachmentType::Location);
        $this->lat = $lat;
        $this->lng = $lng;
    }
}
