<?php

namespace NotificationChannels\CmComSmsWhatsApp;

use CMText\Exceptions\ConversationLimitException;
use CMText\Exceptions\MessagesLimitException;
use CMText\Exceptions\RecipientLimitException;
use CMText\Exceptions\WhatsappTemplateComponentParameterTypeException;
use CMText\Message;
use CMText\RichContent\Messages\MediaMessage;
use CMText\RichContent\Messages\TemplateMessage;
use CMText\RichContent\Templates\Whatsapp\ComponentBody;
use CMText\RichContent\Templates\Whatsapp\ComponentButtonUrl;
use CMText\RichContent\Templates\Whatsapp\ComponentFooter;
use CMText\RichContent\Templates\Whatsapp\ComponentHeader;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterText;
use CMText\RichContent\Templates\Whatsapp\Language;
use CMText\RichContent\Templates\Whatsapp\WhatsappTemplate;
use CMText\TextClient;
use CMText\TextClientResult;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\CmComSmsWhatsApp\Types\CmComSmsMessageType;
use NotificationChannels\CmComSmsWhatsApp\Types\CmComWhatsAppMessageTemplateType;
use NotificationChannels\CmComSmsWhatsApp\Types\CmComWhatsAppMessageType;
use NotificationChannels\CmComSmsWhatsApp\Types\Subtypes\RichContentMessageMediaSubtype;
use NotificationChannels\CmComSmsWhatsApp\Types\RichContentMessageType;

class CmComSmsWhatsAppChannel
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
     * @throws WhatsappTemplateComponentParameterTypeException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->routeNotificationFor('Cmsmswa')) {
            return;
        }

        /** @var CmComSmsMessageType|CmComWhatsAppMessageType $notification_message */
        $notification_message = $notification->toCmsmswa($notifiable);

        $messages = [];
        $message = new Message($notification_message->text, $notification_message->from, $notification_message->to, $notification_message->reference ?? null);
        if ($notification_message instanceof CmComWhatsAppMessageType) {
            if ($notification_message->hasMediaContent()) {
                $message = $this->addMediaMessage($message, $notification_message);
            }
        } else if ($notification_message instanceof CmComWhatsAppMessageTemplateType) {
            $template = new WhatsappTemplate($notification_message->namespace, $notification_message->templateId, new Language($notification_message->languageCode));
            $components = [];
            if ($notification_message->hasHeaderImage()) {
                $image = $notification_message->parameters->getHeaderImage();
                $components[] = new ComponentHeader([$image]);
            }
            if ($notification_message->hasBodyParameters()) {
                $components[] = new ComponentBody($notification_message->parameters->getBody());
            }
            if ($notification_message->hasCtasParameters()) {
                $ctas = $notification_message->parameters->getCtas();
                for ($iterator = 0; $iterator < count($ctas); $iterator++) {
                    $components[] = new ComponentButtonUrl($iterator, new ComponentParameterText($ctas[$iterator]));
                }
            }
            // TODO: check component HEADER!
            $template->addComponents($components);
            $message->WithTemplate(new TemplateMessage($template));
        }
        Log::debug(json_encode($message));
        $messages[] = $message->WithChannels([$notification_message->getMessageAppChannel()]);

        $result = $this->client->send($messages);
        Log::info(json_encode($result));
        return $result;
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
}
