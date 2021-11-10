<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

use CMText\Channels;
use NotificationChannels\CmComSmsWhatsApp\Interfaces\SendableMessageInterface;

/**
 * SMS Message type
 */
class CmComSmsMessageTypeType extends CmComBaseMessageType implements SendableMessageInterface
{
    /**
     * @inheritDoc
     */
    public function getMessageAppChannel(): string
    {
        return Channels::SMS;
    }
}
