<?php

namespace NotificationChannels\CmComWhatsApp;

use CMText\MessageBody;

class CmComWhatsAppMessage
{
    /**
     * @var MessageBody
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

    /**
     * @param MessageBody $text
     * @param array $to
     * @param string $from
     * @param string|null $reference
     */
    public function __construct(MessageBody $text, array $to, string $from, string $reference = null)
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
