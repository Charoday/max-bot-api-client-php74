<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot;

use Charoday\MaxMessengerBot\Enums\UpdateType;
use Charoday\MaxMessengerBot\Exceptions\SecurityException;
use Charoday\MaxMessengerBot\Models\Updates\AbstractUpdate;
use Charoday\MaxMessengerBot\Models\Updates\MessageCreatedUpdate;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

/**
 * Dispatches incoming updates to registered handlers.
 * This is the central event dispatcher for the bot.
 */
class UpdateDispatcher
{
    /**
     * @var array<string, callable[]> Map of update types to handler callbacks.
     */
    private $handlers = [];

    /**
     * @var array<string, callable[]> Map of command names to handler callbacks.
     */
    private $commandHandlers = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * Adds a handler for a specific update type.
     *
     * @param UpdateType $type The type of update to handle.
     * @param callable $handler The callback to execute when the update occurs.
     */
    public function addHandler($type, callable $handler)
    {
        $this->handlers[$type][] = $handler;
    }

    /**
     * Registers a handler for a specific command (message starting with /).
     *
     * @param string $command The command name (without the leading slash).
     * @param callable $handler The callback to execute when the command is received.
     */
    public function onCommand($command, callable $handler)
    {
        $this->commandHandlers[mb_strtolower($command)] = $handler;
    }

    /**
     * Registers a handler for message_created updates.
     *
     * @param callable $handler
     */
    public function onMessageCreated(callable $handler)
    {
        $this->addHandler(UpdateType::MessageCreated, $handler);
    }

    /**
     * Registers a handler for message_callback updates.
     *
     * @param callable $handler
     */
    public function onMessageCallback(callable $handler)
    {
        $this->addHandler(UpdateType::MessageCallback, $handler);
    }

    /**
     * Registers a handler for message_edited updates.
     *
     * @param callable $handler
     */
    public function onMessageEdited(callable $handler)
    {
        $this->addHandler(UpdateType::MessageEdited, $handler);
    }

    /**
     * Registers a handler for message_removed updates.
     *
     * @param callable $handler
     */
    public function onMessageRemoved(callable $handler)
    {
        $this->addHandler(UpdateType::MessageRemoved, $handler);
    }

    /**
     * Registers a handler for bot_added updates.
     *
     * @param callable $handler
     */
    public function onBotAdded(callable $handler)
    {
        $this->addHandler(UpdateType::BotAdded, $handler);
    }

    /**
     * Registers a handler for bot_removed updates.
     *
     * @param callable $handler
     */
    public function onBotRemoved(callable $handler)
    {
        $this->addHandler(UpdateType::BotRemoved, $handler);
    }

    /**
     * Registers a handler for dialog_muted updates.
     *
     * @param callable $handler
     */
    public function onDialogMuted(callable $handler)
    {
        $this->addHandler(UpdateType::DialogMuted, $handler);
    }

    /**
     * Registers a handler for dialog_unmuted updates.
     *
     * @param callable $handler
     */
    public function onDialogUnmuted(callable $handler)
    {
        $this->addHandler(UpdateType::DialogUnmuted, $handler);
    }

    /**
     * Registers a handler for dialog_cleared updates.
     *
     * @param callable $handler
     */
    public function onDialogCleared(callable $handler)
    {
        $this->addHandler(UpdateType::DialogCleared, $handler);
    }

    /**
     * Registers a handler for dialog_removed updates.
     *
     * @param callable $handler
     */
    public function onDialogRemoved(callable $handler)
    {
        $this->addHandler(UpdateType::DialogRemoved, $handler);
    }

    /**
     * Registers a handler for user_added updates.
     *
     * @param callable $handler
     */
    public function onUserAdded(callable $handler)
    {
        $this->addHandler(UpdateType::UserAdded, $handler);
    }

    /**
     * Registers a handler for user_removed updates.
     *
     * @param callable $handler
     */
    public function onUserRemoved(callable $handler)
    {
        $this->addHandler(UpdateType::UserRemoved, $handler);
    }

    /**
     * Registers a handler for bot_started updates.
     *
     * @param callable $handler
     */
    public function onBotStarted(callable $handler)
    {
        $this->addHandler(UpdateType::BotStarted, $handler);
    }

    /**
     * Registers a handler for bot_stopped updates.
     *
     * @param callable $handler
     */
    public function onBotStopped(callable $handler)
    {
        $this->addHandler(UpdateType::BotStopped, $handler);
    }

    /**
     * Registers a handler for chat_title_changed updates.
     *
     * @param callable $handler
     */
    public function onChatTitleChanged(callable $handler)
    {
        $this->addHandler(UpdateType::ChatTitleChanged, $handler);
    }

    /**
     * Registers a handler for message_chat_created updates.
     *
     * @param callable $handler
     */
    public function onMessageChatCreated(callable $handler)
    {
        $this->addHandler(UpdateType::MessageChatCreated, $handler);
    }

    /**
     * Dispatches an update to all registered handlers.
     *
     * @param AbstractUpdate $update The update to dispatch.
     * @throws SecurityException
     */
    public function dispatch(AbstractUpdate $update)
    {
        $updateType = $this->getUpdateType($update);
        $this->logger->debug('Dispatching update', [
            'type' => $updateType,
            'update_class' => get_class($update),
        ]);

        // First, try to dispatch to command handlers if it's a message
        if ($update instanceof MessageCreatedUpdate) {
            $this->dispatchCommand($update);
        }

        // Then dispatch to general update handlers
        if (isset($this->handlers[$updateType])) {
            foreach ($this->handlers[$updateType] as $handler) {
                try {
                    $handler($update);
                } catch (Throwable $e) {
                    $this->logger->error('Handler for update type ' . $updateType . ' threw an exception', [
                        'exception' => $e,
                    ]);
                    // Continue with other handlers even if one fails
                }
            }
        }
    }

    /**
     * Gets the update type string from an update object.
     *
     * @param AbstractUpdate $update
     * @return string
     */
    private function getUpdateType(AbstractUpdate $update)
    {
        // Map class names to update types
        $classToType = [
            MessageCreatedUpdate::class => UpdateType::MessageCreated,
            \Charoday\MaxMessengerBot\Models\Updates\MessageCallbackUpdate::class => UpdateType::MessageCallback,
            \Charoday\MaxMessengerBot\Models\Updates\MessageEditedUpdate::class => UpdateType::MessageEdited,
            \Charoday\MaxMessengerBot\Models\Updates\MessageRemovedUpdate::class => UpdateType::MessageRemoved,
            \Charoday\MaxMessengerBot\Models\Updates\BotAddedUpdate::class => UpdateType::BotAdded,
            \Charoday\MaxMessengerBot\Models\Updates\BotRemovedUpdate::class => UpdateType::BotRemoved,
            \Charoday\MaxMessengerBot\Models\Updates\DialogMutedUpdate::class => UpdateType::DialogMuted,
            \Charoday\MaxMessengerBot\Models\Updates\DialogUnmutedUpdate::class => UpdateType::DialogUnmuted,
            \Charoday\MaxMessengerBot\Models\Updates\DialogClearedUpdate::class => UpdateType::DialogCleared,
            \Charoday\MaxMessengerBot\Models\Updates\DialogRemovedUpdate::class => UpdateType::DialogRemoved,
            \Charoday\MaxMessengerBot\Models\Updates\UserAddedUpdate::class => UpdateType::UserAdded,
            \Charoday\MaxMessengerBot\Models\Updates\UserRemovedUpdate::class => UpdateType::UserRemoved,
            \Charoday\MaxMessengerBot\Models\Updates\BotStartedUpdate::class => UpdateType::BotStarted,
            \Charoday\MaxMessengerBot\Models\Updates\BotStoppedUpdate::class => UpdateType::BotStopped,
            \Charoday\MaxMessengerBot\Models\Updates\ChatTitleChangedUpdate::class => UpdateType::ChatTitleChanged,
            \Charoday\MaxMessengerBot\Models\Updates\MessageChatCreatedUpdate::class => UpdateType::MessageChatCreated,
        ];

        $className = get_class($update);
        if (isset($classToType[$className])) {
            return $classToType[$className];
        }

        throw new \LogicException("Unknown update type for class: $className");
    }

    /**
     * Dispatches a command if the message starts with a slash.
     *
     * @param MessageCreatedUpdate $update
     */
    private function dispatchCommand(MessageCreatedUpdate $update)
    {
        if (!isset($update->message->text) || empty($update->message->text) || mb_strpos($update->message->text, '/') !== 0) {
            return;
        }

        // Extract command (everything before first space or end of string)
        $parts = explode(' ', $update->message->text, 2);
        $fullCommand = $parts[0];
        $command = mb_strtolower(mb_substr($fullCommand, 1)); // Remove leading slash

        // Handle commands with bot username (e.g., /start@mybot)
        if (mb_strpos($command, '@') !== false) {
            [$command, $botUsername] = explode('@', $command, 2);
            // In a real implementation, you might want to verify $botUsername matches your bot
        }

        if (isset($this->commandHandlers[$command])) {
            $this->logger->debug('Dispatching command', ['command' => $command]);
            try {
                $this->commandHandlers[$command]($update);
            } catch (Throwable $e) {
                $this->logger->error('Command handler for ' . $command . ' threw an exception', [
                    'exception' => $e,
                ]);
            }
        }
    }
}
