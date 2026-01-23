<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a dialog is unmuted by the user.
 */
class DialogUnmutedUpdate extends AbstractUpdate
{
    /**
     * @var int User ID who unmuted the dialog.
     */
    public $userId;

    /**
     * DialogUnmutedUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param int $userId
     */
    public function __construct($mid, $time, $marker, $userId)
    {
        parent::__construct($mid, $time, $marker);
        $this->userId = $userId;
    }
}
