<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a patch for updating chat information.
 */
class ChatPatch extends AbstractModel
{
    /**
     * @var string|null New chat title.
     */
    public $title;

    /**
     * @var string|null New chat description.
     */
    public $about;

    /**
     * @var string|null New public link for the chat.
     */
    public $publicLink;

    /**
     * ChatPatch constructor.
     *
     * @param string|null $title
     * @param string|null $about
     * @param string|null $publicLink
     */
    public function __construct($title = null, $about = null, $publicLink = null)
    {
        $this->title = $title;
        $this->about = $about;
        $this->publicLink = $publicLink;
    }
}
