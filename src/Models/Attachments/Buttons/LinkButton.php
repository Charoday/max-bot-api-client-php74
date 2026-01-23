<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models\Attachments\Buttons;

use Charoday\MaxMessengerBot\Enums\InlineButtonType;
use Charoday\MaxMessengerBot\Enums\Intent;

/**
 * Represents a button that opens an external URL.
 */
class LinkButton extends AbstractButton
{
    /**
     * @var string Button text.
     */
    public $text;

    /**
     * @var string URL to open.
     */
    public $url;

    /**
     * @var string Intent of the button.
     */
    public $intent;

    /**
     * LinkButton constructor.
     *
     * @param string $text
     * @param string $url
     * @param string $intent
     */
    public function __construct($text, $url, $intent = Intent::Default)
    {
        parent::__construct(InlineButtonType::Link);
        $this->text = $text;
        $this->url = $url;
        $this->intent = $intent;
    }
}
