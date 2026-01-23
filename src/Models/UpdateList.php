<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

use Charoday\MaxMessengerBot\Models\Updates\AbstractUpdate;

/**
 * Represents a list of updates received from the API.
 */
class UpdateList extends AbstractModel
{
    /**
     * @var AbstractUpdate[] List of updates.
     */
    public $list;

    /**
     * @var int|null Marker for pagination.
     */
    public $marker;

    /**
     * UpdateList constructor.
     *
     * @param AbstractUpdate[] $list
     * @param int|null $marker
     */
    public function __construct($list, $marker = null)
    {
        $this->list = $list;
        $this->marker = $marker;
    }
}
