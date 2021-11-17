<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

class PlainTextMessageType
{

    /**
     * @var string
     */
    public string $text;

    /**
     * @var array List of Recipients
     * @note Twitter requires the snowflake-id
     */
    public array $to = [];

    /**
     * @var string Sender name
     * @note Twitter requires the snowflake-id of the account you want to use as sender
     */
    public string $from;

    public function __construct(string $from, array $to, string $text)
    {
        $this->from = $from;
        $this->to = $to;
        $this->text = $text;
    }
}
