<?php

namespace NotificationChannels\CmComWhatsApp;

use CMText\Channels;
use CMText\Exceptions\ConversationLimitException;
use CMText\Exceptions\MessagesLimitException;
use CMText\Exceptions\RecipientLimitException;
use CMText\Exceptions\SuggestionsLimitException;
use CMText\Message;
use CMText\RichContent\Messages\MediaMessage;
use CMText\RichContent\Suggestions\ReplySuggestion;
use CMText\TextClient;
use CMText\TextClientResult;
use Illuminate\Notifications\Notification;
use NotificationChannels\CmComWhatsApp\Types\PlainTextMessageType;
use NotificationChannels\CmComWhatsApp\Types\RichContentMessageMediaSubtype;
use NotificationChannels\CmComWhatsApp\Types\RichContentMessageReplySuggestionSubtype;
use NotificationChannels\CmComWhatsApp\Types\RichContentMessageType;

class CmComWhatsAppChannel
{

    /** @var TextClient */
    protected $client;

    public function __construct(TextClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return TextClientResult|void
     * @throws ConversationLimitException
     * @throws MessagesLimitException
     * @throws RecipientLimitException
     * @throws SuggestionsLimitException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->routeNotificationFor('Cmwa')) {
            return;
        }

        /** @var PlainTextMessageType|RichContentMessageType $notification_message */
        $notification_message = $notification->toCmwa($notifiable);

        $messages = [];
        $message = new Message($notification_message->text, $notification_message->from, $notification_message->to, $notification_message->reference);
        if ($notification_message instanceof RichContentMessageType) {
            if ($notification_message->hasMediaContent()) {
                $message = $this->addMediaMessage($message, $notification_message);
            }
            if ($notification_message->hasReplySuggestions()) {
                $message = $this->addReplySuggestions($message, $notification_message);
            }
        }
        $messages[] = $message->WithChannels([Channels::WHATSAPP]);

        return $this->client->send($messages);
    }

    /**
     * @throws ConversationLimitException
     */
    private function addMediaMessage(Message $message, RichContentMessageType $notification_message): Message
    {
        if (is_null($notification_message->media_content)) {
            return $message;
        }
        /** @var  RichContentMessageMediaSubtype $media_content */
        $media_content = $notification_message->media_content;
        return $message->WithRichMessage(new MediaMessage($media_content->name, $media_content->media_url, $media_content->media_content_type));
    }

    /**
     * @throws SuggestionsLimitException
     */
    private function addReplySuggestions(Message $message, RichContentMessageType $notification_message): Message
    {
        /** @var RichContentMessageReplySuggestionSubtype[] $reply_suggestions */
        $reply_suggestions = $notification_message->reply_suggestions;
        $reply_suggestions_array = array_map(function (RichContentMessageReplySuggestionSubtype $reply_suggestion) {
            return new ReplySuggestion($reply_suggestion->label, $reply_suggestion->payload);
        }, $reply_suggestions);
        if (count($reply_suggestions_array) > 0) {
            return $message->WithSuggestions($reply_suggestions_array);
        }
        return $message;
    }
}
