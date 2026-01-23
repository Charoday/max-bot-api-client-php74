<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a patch for updating bot information.
 */
class BotPatch extends AbstractModel
{
    /**
     * @var string|null New bot name.
     */
    public $name;

    /**
     * @var string|null New bot description.
     */
    public $description;

    /**
     * BotPatch constructor.
     *
     * @param string|null $name
     * @param string|null $description
     */
    public function __construct($name = null, $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }
}
