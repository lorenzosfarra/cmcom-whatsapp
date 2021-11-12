<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

class PlainTextWithReferenceMessageType extends PlainTextMessageType
{
    /**
     * @var string Reference for message lookup and identification
     */
    public $reference;

    public function __construct(string $from, array $to, string $text, ?string $reference = null)
    {
        parent::__construct($from, $to, $text);
        $this->reference = $reference;
    }
}
