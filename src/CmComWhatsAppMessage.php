<?php

namespace NotificationChannels\CmComWhatsApp;

use NotificationChannels\CmComWhatsApp\Types\RichContentMessageMediaSubtype;
use NotificationChannels\CmComWhatsApp\Types\RichContentMessageReplySuggestionSubtype;
use NotificationChannels\CmComWhatsApp\Types\RichContentMessageType;

class CmComWhatsAppMessage extends RichContentMessageType
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

    /**
     * @param RichContentMessageMediaSubtype $media
     */
    public function addMediaContent(RichContentMessageMediaSubtype $media)
    {
        $this->media_content = $media;
    }

    /**
     * @param RichContentMessageReplySuggestionSubtype[] $suggestedReplies
     */
    public function addSuggestedReply(array $suggestedReplies)
    {
        $this->reply_suggestions = $suggestedReplies;
    }
}
