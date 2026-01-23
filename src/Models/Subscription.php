<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a webhook subscription.
 */
class Subscription extends AbstractModel
{
    /**
     * @var string Webhook URL.
     */
    public $url;

    /**
     * @var string[]|null List of update types subscribed to.
     */
    public $updateTypes;

    /**
     * @var int Timestamp when the subscription was created.
     */
    public $time;

    /**
     * Subscription constructor.
     *
     * @param string $url
     * @param string[]|null $updateTypes
     * @param int $time
     */
    public function __construct($url, $updateTypes = null, $time)
    {
        $this->url = $url;
        $this->updateTypes = $updateTypes;
        $this->time = $time;
    }
}
