<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

use Charoday\MaxMessengerBot\Models\AbstractModel;

/**
 * Base class for all update types.
 */
abstract class AbstractUpdate extends AbstractModel
{
    /**
     * @var string Message ID associated with the update.
     */
    public $mid;

    /**
     * @var int Timestamp when the update occurred.
     */
    public $time;

    /**
     * @var int Marker for pagination.
     */
    public $marker;

    /**
     * AbstractUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     */
    public function __construct($mid, $time, $marker)
    {
        $this->mid = $mid;
        $this->time = $time;
        $this->marker = $marker;
    }
}
