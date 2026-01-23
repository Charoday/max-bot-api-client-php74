<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Updates;

/**
 * Represents an update when a chat title is changed.
 */
class ChatTitleChangedUpdate extends AbstractUpdate
{
    /**
     * @var int Chat ID where the title was changed.
     */
    public $chatId;

    /**
     * @var string New chat title.
     */
    public $title;

    /**
     * ChatTitleChangedUpdate constructor.
     *
     * @param string $mid
     * @param int $time
     * @param int $marker
     * @param int $chatId
     * @param string $title
     */
    public function __construct($mid, $time, $marker, $chatId, $title)
    {
        parent::__construct($mid, $time, $marker);
        $this->chatId = $chatId;
        $this->title = $title;
    }
}
