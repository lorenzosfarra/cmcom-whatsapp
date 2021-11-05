<?php

namespace NotificationChannels\CmComWhatsApp;

use CMText\TextClient;
use Illuminate\Notifications\Notification;
use NotificationChannels\CmComWhatsApp\Types\PlainTextMessageType;

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
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \CMText\Exceptions\MessagesLimitException
     * @throws \CMText\Exceptions\RecipientLimitException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->routeNotificationFor('Cmwa')) {
            return;
        }

        /** @var PlainTextMessageType $message */
        $message = $notification->toCmwa($notifiable);

        $this->client->sendMessage($message->text, $message->from, $message->to, $message->reference);
    }
}
