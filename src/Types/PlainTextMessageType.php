<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

class PlainTextMessageType
{

    /**
     * @var string
     */
    public $text;

    /**
     * @var string Reference for message lookup and identification
     */
    public $reference;

    /**
     * @var array List of Recipients
     * @note Twitter requires the snowflake-id
     */
    public $to = [];

    /**
     * @var string Sender name
     * @note Twitter requires the snowflake-id of the account you want to use as sender
     */
    public $from;
}
