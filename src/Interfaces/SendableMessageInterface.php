<?php

namespace NotificationChannels\CmComSmsWhatsApp\Interfaces;

interface SendableMessageInterface
{
    /**
     * the channel (see CMText\Channels)
     *
     * @return string
     */
    public function getMessageAppChannel(): string;
}
