<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a user in the system.
 */
class User extends AbstractModel
{
    /**
     * @var int User's unique identifier.
     */
    public $id;

    /**
     * @var string User's first name.
     */
    public $firstName;

    /**
     * @var string|null User's last name.
     */
    public $lastName;

    /**
     * @var string|null User's username.
     */
    public $username;

    /**
     * @var string|null URL to the user's avatar.
     */
    public $avatar;

    /**
     * User constructor.
     *
     * @param int $id
     * @param string $firstName
     * @param string|null $lastName
     * @param string|null $username
     * @param string|null $avatar
     */
    public function __construct($id, $firstName, $lastName = null, $username = null, $avatar = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->avatar = $avatar;
    }
}
