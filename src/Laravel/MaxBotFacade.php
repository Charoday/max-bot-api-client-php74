<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Laravel;

use Charoday\MaxMessengerBot\Api;
use Charoday\MaxMessengerBot\Enums\MessageFormat;
use Charoday\MaxMessengerBot\Enums\SenderAction;
use Charoday\MaxMessengerBot\Enums\UpdateType;
use Charoday\MaxMessengerBot\Enums\UploadType;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\AbstractAttachmentRequest;
use Charoday\MaxMessengerBot\Models\BotInfo;
use Charoday\MaxMessengerBot\Models\BotPatch;
use Charoday\MaxMessengerBot\Models\Chat;
use Charoday\MaxMessengerBot\Models\ChatAdmin;
use Charoday\MaxMessengerBot\Models\ChatList;
use Charoday\MaxMessengerBot\Models\ChatMember;
use Charoday\MaxMessengerBot\Models\ChatMembersList;
use Charoday\MaxMessengerBot\Models\ChatPatch;
use Charoday\MaxMessengerBot\Models\Message;
use Charoday\MaxMessengerBot\Models\MessageLink;
use Charoday\MaxMessengerBot\Models\Result;
use Charoday\MaxMessengerBot\Models\Subscription;
use Charoday\MaxMessengerBot\Models\UpdateList;
use Charoday\MaxMessengerBot\Models\UploadEndpoint;
use Charoday\MaxMessengerBot\Models\VideoAttachmentDetails;
use Charoday\MaxMessengerBot\UpdateDispatcher;
use Charoday\MaxMessengerBot\WebhookHandler;
use Charoday\MaxMessengerBot\LongPollingHandler;
use Illuminate\Support\Facades\Facade;

/**
 * Laravel Facade for Max Bot API Client.
 *
 * Provides static access to the Max Bot API methods through Laravel's facade system.
 *
 * @method static array<string, mixed> request(string $method, string $uri, array<string, mixed> $queryParams = [], array<string, mixed> $body = [])
 * @method static UpdateDispatcher getUpdateDispatcher()
 * @method static WebhookHandler createWebhookHandler(?string $secret = null)
 * @method static LongPollingHandler createLongPollingHandler()
 * @method static UpdateList getUpdates(?int $limit = null, ?int $timeout = null, ?int $marker = null, ?array $types = null)
 * @method static BotInfo getBotInfo()
 * @method static Subscription[] getSubscriptions()
 * @method static Result subscribe(string $url, ?string $secret = null, ?array $updateTypes = null)
 * @method static Result unsubscribe(string $url)
 * @method static Message sendMessage(?int $userId = null, ?int $chatId = null, ?string $text = null, ?array $attachments = null, ?MessageFormat $format = null, ?MessageLink $link = null, bool $notify = true, bool $disableLinkPreview = false)
 * @method static Message sendUserMessage(?int $userId = null, ?string $text = null, ?array $attachments = null, ?MessageFormat $format = null, ?MessageLink $link = null, bool $notify = true, bool $disableLinkPreview = false)
 * @method static Message sendChatMessage(?int $chatId = null, ?string $text = null, ?array $attachments = null, ?MessageFormat $format = null, ?MessageLink $link = null, bool $notify = true, bool $disableLinkPreview = false)
 * @method static UploadEndpoint getUploadUrl(UploadType $type)
 * @method static AbstractAttachmentRequest uploadAttachment(UploadType $type, string $filePath)
 * @method static Chat getChat(int $chatId)
 * @method static Chat getChatByLink(string $chatLink)
 * @method static ChatList getChats(?int $count = null, ?int $marker = null)
 * @method static Result deleteChat(int $chatId)
 * @method static Result sendAction(int $chatId, SenderAction $action)
 * @method static Message|null getPinnedMessage(int $chatId)
 * @method static Result unpinMessage(int $chatId)
 * @method static ChatMember getMembership(int $chatId)
 * @method static Result leaveChat(int $chatId)
 * @method static Message[] getMessages(int $chatId, ?array $messageIds = null, ?int $from = null, ?int $to = null, ?int $count = null)
 * @method static Result deleteMessage(string $messageId)
 * @method static Message getMessageById(string $messageId)
 * @method static Result pinMessage(int $chatId, string $messageId, bool $notify = true)
 * @method static ChatMembersList getAdmins(int $chatId)
 * @method static ChatMembersList getMembers(int $chatId, ?array $userIds = null, ?int $marker = null, ?int $count = null)
 * @method static Result deleteAdmin(int $chatId, int $userId)
 * @method static Result deleteMember(int $chatId, int $userId, bool $block = false)
 * @method static Result addAdmins(int $chatId, array $admins)
 * @method static Result addMembers(int $chatId, array $userIds)
 * @method static Result answerOnCallback(string $callbackId, ?string $notification = null, ?string $text = null, ?array $attachments = null, ?MessageLink $link = null, ?MessageFormat $format = null, bool $notify = true)
 * @method static Result editMessage(string $messageId, ?string $text = null, ?array $attachments = null, ?MessageFormat $format = null, ?MessageLink $link = null, bool $notify = true)
 * @method static BotInfo editBotInfo(BotPatch $botPatch)
 * @method static Chat editChat(int $chatId, ChatPatch $chatPatch)
 * @method static VideoAttachmentDetails getVideoAttachmentDetails(string $videoToken)
 *
 * @see Api
 * @codeCoverageIgnore
 */
class MaxBotFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'maxbot';
    }
}
