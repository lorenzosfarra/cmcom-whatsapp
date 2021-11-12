<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

class RichContentMessageType extends PlainTextWithReferenceMessageType
{
    /*
     * @var \NotificationChannels\CmComSmsWhatsApp\Types\Subtypes\RichContentMessageMediaSubtype|null $media_content
     */
    public $media_content = null;


    public function hasMediaContent(): bool
    {
        return !is_null($this->media_content);
    }
}
