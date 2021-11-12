<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

use CMText\Channels;
use NotificationChannels\CmComSmsWhatsApp\Interfaces\SendableMessageInterface;
use NotificationChannels\CmComSmsWhatsApp\Types\Subtypes\RichContentMessageMediaSubtype;

/**
 * WhatsApp Message type
 */
class CmComWhatsAppMessageType extends RichContentMessageType implements SendableMessageInterface
{
    /**
     * @param RichContentMessageMediaSubtype $media
     */
    public function addMediaContent(RichContentMessageMediaSubtype $media)
    {
        $this->media_content = $media;
    }

    /**
     * @inheritDoc
     */
    public function getMessageAppChannel(): string
    {
        return Channels::WHATSAPP;
    }
}
