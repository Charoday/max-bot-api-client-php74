<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Buttons;

use Charoday\MaxMessengerBot\Models\AbstractModel;

/**
 * Base class for all button types in keyboards.
 */
abstract class AbstractButton extends AbstractModel
{
    /**
     * @var string The type of the button.
     */
    public $type;

    /**
     * AbstractButton constructor.
     *
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }
}
