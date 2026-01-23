<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents information about the bot.
 */
class BotInfo extends AbstractModel
{
    /**
     * @var int Bot's unique identifier.
     */
    public $id;

    /**
     * @var string Bot's name.
     */
    public $name;

    /**
     * @var string|null Bot's description.
     */
    public $description;

    /**
     * @var string|null URL to the bot's icon.
     */
    public $icon;

    /**
     * @var string|null Public link to the bot.
     */
    public $link;

    /**
     * @var string|null Bot's username.
     */
    public $username;

    /**
     * BotInfo constructor.
     *
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @param string|null $icon
     * @param string|null $link
     * @param string|null $username
     */
    public function __construct($id, $name, $description = null, $icon = null, $link = null, $username = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->icon = $icon;
        $this->link = $link;
        $this->username = $username;
    }
}
