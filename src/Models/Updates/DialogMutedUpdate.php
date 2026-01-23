<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a dialog is muted by the user.
 */
class DialogMutedUpdate extends AbstractUpdate
{
    /**
     * @var int User ID who muted the dialog.
     */
    public $userId;

    /**
     * DialogMutedUpdate constructor.
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
