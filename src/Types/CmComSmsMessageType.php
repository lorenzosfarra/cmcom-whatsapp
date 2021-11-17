<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

use CMText\Channels;
use NotificationChannels\CmComSmsWhatsApp\Interfaces\SendableMessageInterface;

/**
 * SMS Message type
 */
class CmComSmsMessageType extends PlainTextMessageType implements SendableMessageInterface
{

    public ?string $reference;

    public function __construct(string $from, array $to, string $text, ?string $reference = null)
    {
        parent::__construct($from, $to, $text);
        $this->reference = $reference;
    }

    /**
     * @inheritDoc
     */
    public function getMessageAppChannel(): string
    {
        return Channels::SMS;
    }
}
