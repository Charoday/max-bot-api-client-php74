<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a dialog is cleared by the user.
 */
class DialogClearedUpdate extends AbstractUpdate
{
    /**
     * @var int User ID who cleared the dialog.
     */
    public $userId;

    /**
     * DialogClearedUpdate constructor.
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
