<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Models;

/**
 * Represents a generic API operation result.
 */
class Result extends AbstractModel
{
    /**
     * @var bool Whether the operation was successful.
     */
    public $success;

    /**
     * @var string|null Error message if the operation failed.
     */
    public $message;

    /**
     * Result constructor.
     *
     * @param bool $success
     * @param string|null $message
     */
    public function __construct($success, $message = null)
    {
        $this->success = $success;
        $this->message = $message;
    }
}
