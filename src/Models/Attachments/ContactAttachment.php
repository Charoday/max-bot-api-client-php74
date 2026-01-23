<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments;

use Charoday\MaxMessengerBot\Enums\AttachmentType;

/**
 * Represents a contact attachment in a message.
 */
class ContactAttachment extends AbstractAttachment
{
    /**
     * @var string Phone number of the contact.
     */
    public $phone;

    /**
     * @var string First name of the contact.
     */
    public $firstName;

    /**
     * @var string|null Last name of the contact.
     */
    public $lastName;

    /**
     * @var string|null vCard data of the contact.
     */
    public $vcard;

    /**
     * ContactAttachment constructor.
     *
     * @param string $phone
     * @param string $firstName
     * @param string|null $lastName
     * @param string|null $vcard
     */
    public function __construct($phone, $firstName, $lastName = null, $vcard = null)
    {
        parent::__construct(AttachmentType::Contact);
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->vcard = $vcard;
    }
}
