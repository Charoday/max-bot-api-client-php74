<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot;

use Charoday\MaxMessengerBot\Enums\AttachmentType;
use Charoday\MaxMessengerBot\Enums\ChatAdminPermission;
use Charoday\MaxMessengerBot\Enums\ChatStatus;
use Charoday\MaxMessengerBot\Enums\ChatType;
use Charoday\MaxMessengerBot\Enums\InlineButtonType;
use Charoday\MaxMessengerBot\Enums\Intent;
use Charoday\MaxMessengerBot\Enums\MarkupType;
use Charoday\MaxMessengerBot\Enums\MessageFormat;
use Charoday\MaxMessengerBot\Enums\MessageLinkType;
use Charoday\MaxMessengerBot\Enums\ReplyButtonType;
use Charoday\MaxMessengerBot\Enums\SenderAction;
use Charoday\MaxMessengerBot\Enums\UpdateType;
use Charoday\MaxMessengerBot\Enums\UploadType;
use Charoday\MaxMessengerBot\Exceptions\SerializationException;
use Charoday\MaxMessengerBot\Models\AbstractModel;
use Charoday\MaxMessengerBot\Models\Attachments\AbstractAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\AudioAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\ContactAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\DataAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\FileAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\ImageAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\InlineKeyboardAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\LocationAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\ReplyKeyboardAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\ShareAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\StickerAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\VideoAttachment;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\AbstractButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\CallbackButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\ChatButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\LinkButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\MessageButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\OpenAppButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\RequestContactButton;
use Charoday\MaxMessengerBot\Models\Attachments\Buttons\RequestGeoLocationButton;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\AbstractAttachmentRequest;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\AudioAttachmentRequest;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\FileAttachmentRequest;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\PhotoAttachmentRequest;
use Charoday\MaxMessengerBot\Models\Attachments\Requests\VideoAttachmentRequest;
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
use Charoday\MaxMessengerBot\Models\User;
use Charoday\MaxMessengerBot\Models\VideoAttachmentDetails;
use Charoday\MaxMessengerBot\Models\Updates\AbstractUpdate;
use Charoday\MaxMessengerBot\Models\Updates\MessageCallbackUpdate;
use Charoday\MaxMessengerBot\Models\Updates\MessageCreatedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\MessageEditedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\MessageRemovedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\BotAddedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\BotRemovedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\DialogMutedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\DialogUnmutedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\DialogClearedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\DialogRemovedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\UserAddedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\UserRemovedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\BotStartedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\BotStoppedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\ChatTitleChangedUpdate;
use Charoday\MaxMessengerBot\Models\Updates\MessageChatCreatedUpdate;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use ReflectionException;
use RuntimeException;

/**
 * Factory class responsible for creating model instances from raw API data.
 * This class handles the deserialization of JSON responses into strongly-typed objects.
 */
class ModelFactory
{
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * Creates an UpdateList from raw API data.
     *
     * @param array<string, mixed> $data
     * @return UpdateList
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createUpdateList($data)
    {   
        $marker = $data['marker'] ?? 0;
        $updates = [];

        // При обработке данных от вэб-хука не приходит массив updates
        if (isset($data['updates']) && is_array($data['updates'])) {
            foreach ($data['updates'] as $item) {
                if (!isset($item['update_type'])) {
                    throw new SerializationException('Invalid update item structure.');
                }
                $updates[] = $this->createUpdate($item['update_type'], $item, $marker);
            }
        }
        else{
            $updates[] = $this->createUpdate($data['update_type'], $data, $marker);
        }

        return new UpdateList($updates, $marker);
    }

    /**
     * Creates a specific update instance based on its type.
     *
     * @param string $type
     * @param array<string, mixed> $data
     * @return AbstractUpdate
     * @throws ReflectionException
     * @throws SerializationException
     */
    private function createUpdate($type, $data, $marker)
    {
        // Общие поля для всех обновлений
        $timestampMs = $data['timestamp'] ?? 0; // миллисекунды
        $timestamp = (int)($timestampMs / 1000); // секунды

        switch ($type) {
            case UpdateType::MessageCreated:
                return new MessageCreatedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $this->createMessage($data['message'] ?? [])
                );

            case UpdateType::MessageCallback:
                return new MessageCallbackUpdate(
                    $data['message']['body']['mid'] ?? '', // или можно использовать callback_id как mid?
                    $timestamp,
                    $marker,
                    $data['callback_id'] ?? '',
                    $data['user_id'] ?? 0,
                    $data['chat_id'] ?? 0,
                    $data['payload'] ?? null
                );

            case UpdateType::MessageEdited:
                return new MessageEditedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $this->createMessage($data['message'] ?? [])
                );

            case UpdateType::MessageRemoved:
                return new MessageRemovedUpdate(
                    $data['message_id'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0
                );

            case UpdateType::BotAdded:
                return new BotAddedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0,
                    $data['user_id'] ?? 0
                );

            case UpdateType::BotRemoved:
                return new BotRemovedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0,
                    $data['user_id'] ?? 0
                );

            case UpdateType::DialogMuted:
                return new DialogMutedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['user_id'] ?? 0
                );

            case UpdateType::DialogUnmuted:
                return new DialogUnmutedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['user_id'] ?? 0
                );

            case UpdateType::DialogCleared:
                return new DialogClearedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['user_id'] ?? 0
                );

            case UpdateType::DialogRemoved:
                return new DialogRemovedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['user_id'] ?? 0
                );

            case UpdateType::UserAdded:
                return new UserAddedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0,
                    $data['user_id'] ?? 0
                );

            case UpdateType::UserRemoved:
                return new UserRemovedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0,
                    $data['user_id'] ?? 0
                );

            case UpdateType::BotStarted:
                return new BotStartedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['user_id'] ?? 0
                );

            case UpdateType::BotStopped:
                return new BotStoppedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['user_id'] ?? 0
                );

            case UpdateType::ChatTitleChanged:
                return new ChatTitleChangedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0,
                    $data['title'] ?? ''
                );

            case UpdateType::MessageChatCreated:
                return new MessageChatCreatedUpdate(
                    $data['message']['body']['mid'] ?? '',
                    $timestamp,
                    $marker,
                    $data['chat_id'] ?? 0
                );

            default:
                throw new SerializationException("Unknown update type: $type");
        }
    }

    /**
     * Creates a BotInfo from raw API data.
     *
     * @param array<string, mixed> $data
     * @return BotInfo
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createBotInfo($data)
    {
        return new BotInfo(
            $data['id'] ?? 0,
            $data['name'] ?? '',
            $data['description'] ?? null,
            $data['icon'] ?? null,
            $data['link'] ?? null,
            $data['username'] ?? null
        );
    }

    /**
     * Creates an array of Subscription from raw API data.
     *
     * @param array<string, mixed> $data
     * @return Subscription[]
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createSubscriptions($data)
    {
        if (!isset($data['subscriptions']) || !is_array($data['subscriptions'])) {
            throw new SerializationException('Invalid subscriptions structure.');
        }

        $result = [];
        foreach ($data['subscriptions'] as $item) {
            $types = null;
            if (isset($item['update_types']) && is_array($item['update_types'])) {
                $types = [];
                foreach ($item['update_types'] as $type) {
                    $types[] = $this->mapStringToEnum($type, UpdateType::class);
                }
            }
            $result[] = new Subscription(
                $item['url'] ?? '',
                $types,
                $item['time'] ?? 0
            );
        }
        return $result;
    }

    /**
     * Creates a Result from raw API data.
     *
     * @param array<string, mixed> $data
     * @return Result
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createResult($data)
    {
        return new Result(
            $data['success'] ?? false,
            $data['message'] ?? null
        );
    }

    /**
     * Creates a Message from raw API data.
     *
     * @param array<string, mixed> $data
     * @return Message
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createMessage($data)
    {
        // --- 1. Извлекаем body ---
        $body = $data['body'] ?? [];
        $mid = $body['mid'] ?? '';
        $text = $body['text'] ?? '';

        // Время: timestamp в миллисекундах → секунды
        $time = isset($data['timestamp']) ? (int)($data['timestamp'] / 1000) : 0;

        // --- 2. Обработка attachments ---
        $attachments = null;
        if (!empty($body['attachments']) && is_array($body['attachments'])) {
            $attachments = [];
            foreach ($body['attachments'] as $attachmentData) {
                $attachments[] = $this->createAttachment($attachmentData);
            }
        }

        // --- 3. Обработка формата (markup → format) ---
        // Примечание: в старой модели `format` — это либо 'markdown', либо 'html'
        // Но в новом API форматирование передаётся через `markup` (массив тегов).
        // Поскольку старая модель не поддерживает rich-разметку, оставляем format = null.
        // Если вы хотите имитировать markdown — можно попытаться преобразовать markup → markdown,
        // но это сложно и не всегда однозначно. Поэтому пока игнорируем.
        $format = null;

        // --- 4. Обработка link (forward / reply) ---
        $link = null;
        if (!empty($data['link']) && is_array($data['link'])) {
            $linkType = $data['link']['type'] ?? null;
            $linkedMessage = $data['link']['message'] ?? [];

            // В старой модели MessageLink принимает: type, mid, chat_id
            if (in_array($linkType, ['forward', 'reply'], true)) {
                $link = new MessageLink(
                    $linkType,
                    $linkedMessage['mid'] ?? '',
                    $data['link']['chat_id'] ?? null
                );
            }
        }

        // --- 5. Sender ---
        $sender = $data['sender'] ?? null;

        // --- 6. Chat (recipient) ---
        $recipient = $data['recipient'] ?? [];
        $chat = [
            'id' => $recipient['chat_id'] ?? null,
            'type' => $recipient['chat_type'] ?? null,
        ];

        // --- 7. Notify — по умолчанию true, API не присылает это поле в ответе на getUpdates
        $notify = true;

        // --- 8. Создаём Message ---
        return new Message(
            $mid,
            $time,
            $text,
            $format,
            $link,
            $attachments,
            $notify,
            $sender,
            $chat
        );
    }

    /**
     * Creates a Message from send/edit response.
     *
     * @param array<string, mixed> $data
     * @return Message
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createMessageFromSendResponse($data)
    {
        if (!isset($data['message']) || !is_array($data['message'])) {
            throw new SerializationException('Invalid message send response structure.');
        }
        return $this->createMessage($data['message']);
    }

    /**
     * Creates an Attachment from raw API data.
     *
     * @param array<string, mixed> $data
     * @return AbstractAttachment
     * @throws ReflectionException
     * @throws SerializationException
     */
    private function createAttachment($data)
    {
        if (!isset($data['type']) || !is_string($data['type'])) {
            throw new SerializationException('Attachment type is missing or invalid.');
        }

        $type = $data['type'];
        $payload = $data['payload'] ?? [];

        switch ($type) {
            case AttachmentType::Image:
                return new ImageAttachment(
                    $payload['token'] ?? '',
                    $payload['url'] ?? null,
                    $payload['photo_id'] ?? 0
                );

            case AttachmentType::Video:
                return new VideoAttachment(
                    $payload['token'] ?? '',
                    $payload['url'] ?? null,
                    $data['thumbnail']['url'] ?? null,
                    $data['width'] ?? null,
                    $data['height'] ?? null,
                    $data['duration'] ?? null
                );

            case AttachmentType::Audio:
                return new AudioAttachment(
                    $payload['token'] ?? '',
                    $payload['url'] ?? null,
                    $data['transcription'] ?? null
                );

            case AttachmentType::File:
                return new FileAttachment(
                    $payload['token'] ?? '',
                    $payload['url'] ?? null,
                    $data['filename'] ?? '',
                    $data['size'] ?? 0
                );

            case AttachmentType::Sticker:
                return new StickerAttachment(
                    $payload['url'] ?? null,
                    $payload['code'] ?? '',
                    $data['width'] ?? 0,
                    $data['height'] ?? 0
                );

            case AttachmentType::Contact:
                $maxInfo = null;
                if (isset($payload['max_info']) && is_array($payload['max_info'])) {
                    $maxInfo = $payload['max_info'];
                }
                return new ContactAttachment(
                    $payload['vcf_info'] ?? null,
                    $maxInfo
                );

            case AttachmentType::InlineKeyboard:
                $buttons = [];
                if (isset($payload['buttons']) && is_array($payload['buttons'])) {
                    foreach ($payload['buttons'] as $_buttonsData) {
                        if(is_array($_buttonsData)){
                            $row = [];
                            foreach ($_buttonsData as $buttonData) {
                                $row[] = $this->createButton($buttonData);
                            }
                            $buttons[] = $row;
                        }else{
                            $buttons[] = $this->createButton($buttonData);
                        }
                    }
                }
                return new InlineKeyboardAttachment($buttons);

            case AttachmentType::Share:
                return new ShareAttachment(
                    $payload['url'] ?? null,
                    $payload['token'] ?? null,
                    $data['title'] ?? null,
                    $data['description'] ?? null,
                    $data['image_url'] ?? null
                );

            case AttachmentType::Location:
                return new LocationAttachment(
                    $payload['latitude'] ?? 0.0,
                    $payload['longitude'] ?? 0.0
                );

            default:
                throw new SerializationException("Unknown attachment type: $type");
        }
    }

    /**
     * Creates a Button from raw API data.
     *
     * @param array<string, mixed> $data
     * @return AbstractButton
     * @throws ReflectionException
     * @throws SerializationException
     */
    private function createButton($data)
    {
        if (!isset($data['type'])) {
            throw new SerializationException('Button type is missing.');
        }

        $type = $data['type'];
        switch ($type) {
            case InlineButtonType::Callback:
                return new CallbackButton(
                    $data['text'] ?? '',
                    $data['payload'] ?? '',
                    $data['intent'] ?? Intent::Default
                );

            case InlineButtonType::Link:
                return new LinkButton(
                    $data['text'] ?? '',
                    $data['url'] ?? ''
                );

            case InlineButtonType::Message:
                return new MessageButton(
                    $data['text'] ?? ''
                );

            case InlineButtonType::RequestGeoLocation:
                return new RequestGeoLocationButton(
                    $data['text'] ?? '',
                    $data['quick'] ?? false
                );

            case InlineButtonType::RequestContact:
                return new RequestContactButton(
                    $data['text'] ?? ''
                );

            case InlineButtonType::OpenApp:
                return new OpenAppButton(
                    $data['text'] ?? '',
                    $data['web_app'] ?? null,
                    $data['contact_id'] ?? null,
                    $data['payload'] ?? null
                );

            /* case InlineButtonType::Chat:
                return new ChatButton(..); */

            default:
                throw new SerializationException("Unknown button type: $type");
        }
    }

    /**
     * Creates an UploadEndpoint from raw API data.
     *
     * @param array<string, mixed> $data
     * @return UploadEndpoint
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createUploadEndpoint($data)
    {
        return new UploadEndpoint(
            $data['url'] ?? '',
            $data['token'] ?? null
        );
    }

    /**
     * Creates a Chat from raw API data.
     *
     * @param array<string, mixed> $data
     * @return Chat
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createChat($data)
    {
        return new Chat(
            $data['id'] ?? 0,
            $this->mapStringToEnum($data['type'], ChatType::class),
            $data['title'] ?? null,
            $data['about'] ?? null,
            $data['icon'] ?? null,
            $data['link'] ?? null,
            $data['members_count'] ?? null,
            $data['public_link'] ?? null,
            $this->mapStringToEnum($data['status'] ?? ChatStatus::Active, ChatStatus::class)
        );
    }

    /**
     * Creates a ChatList from raw API data.
     *
     * @param array<string, mixed> $data
     * @return ChatList
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createChatList($data)
    {
        if (!isset($data['chats']) || !is_array($data['chats'])) {
            throw new SerializationException('Invalid chat list structure.');
        }

        $chats = [];
        foreach ($data['chats'] as $chatData) {
            $chats[] = $this->createChat($chatData);
        }

        return new ChatList(
            $chats,
            $data['marker'] ?? null
        );
    }

    /**
     * Creates a ChatMember from raw API data.
     *
     * @param array<string, mixed> $data
     * @return ChatMember
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createChatMember($data)
    {
        $permissions = null;
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $permissions = [];
            foreach ($data['permissions'] as $perm) {
                $permissions[] = $this->mapStringToEnum($perm, ChatAdminPermission::class);
            }
        }

        return new ChatMember(
            $data['user_id'] ?? 0,
            $data['joined_at'] ?? 0,
            $permissions,
            $data['is_owner'] ?? false
        );
    }

    /**
     * Creates a ChatMembersList from raw API data.
     *
     * @param array<string, mixed> $data
     * @return ChatMembersList
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createChatMembersList($data)
    {
        if (!isset($data['members']) || !is_array($data['members'])) {
            throw new SerializationException('Invalid members list structure.');
        }

        $members = [];
        foreach ($data['members'] as $memberData) {
            $members[] = $this->createChatMember($memberData);
        }

        return new ChatMembersList(
            $members,
            $data['marker'] ?? null
        );
    }

    /**
     * Creates an array of Message from raw API data.
     *
     * @param array<string, mixed> $data
     * @return Message[]
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createMessages($data)
    {
        if (!isset($data['messages']) || !is_array($data['messages'])) {
            throw new SerializationException('Invalid messages structure.');
        }

        $messages = [];
        foreach ($data['messages'] as $messageData) {
            $messages[] = $this->createMessage($messageData);
        }
        return $messages;
    }

    /**
     * Creates a VideoAttachmentDetails from raw API data.
     *
     * @param array<string, mixed> $data
     * @return VideoAttachmentDetails
     * @throws ReflectionException
     * @throws SerializationException
     */
    public function createVideoAttachmentDetails($data)
    {
        return new VideoAttachmentDetails(
            $data['token'] ?? '',
            $data['width'] ?? 0,
            $data['height'] ?? 0,
            $data['duration'] ?? 0,
            $data['size'] ?? 0,
            $data['url'] ?? '',
            $data['preview_url'] ?? null,
            $data['playback_urls'] ?? []
        );
    }

    /**
     * Maps a string value to an enum constant.
     *
     * @param string $value
     * @param string $enumClass
     * @return object
     * @throws SerializationException
     */
    private function mapStringToEnum($value, $enumClass)
    {
        $constants = (new \ReflectionClass($enumClass))->getConstants();
        foreach ($constants as $constName => $constValue) {
            if ($constValue === $value) {
                return $constValue;
            }
        }
        throw new SerializationException("Invalid enum value '$value' for class '$enumClass'");
    }
}
