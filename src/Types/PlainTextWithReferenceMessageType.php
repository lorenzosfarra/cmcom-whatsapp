<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

class PlainTextWithReferenceMessageType extends PlainTextMessageType
{
    /**
     * @var string Reference for message lookup and identification
     */
    public $reference;
}
