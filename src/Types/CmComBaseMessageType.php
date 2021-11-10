<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

class CmComBaseMessageType extends PlainTextMessageType
{

    /**
     * @param string $text
     * @param array $to
     * @param string $from
     * @param string|null $reference
     */
    public function __construct(string $text, array $to, string $from, string $reference = null)
    {
        $this->text = $text;
        $this->to = $to;
        $this->from = $from;
        $this->reference = $reference;
    }

    public function addTo(string $to)
    {
        $this->to[] = $to;
    }
}
