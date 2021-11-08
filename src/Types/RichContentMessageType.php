<?php

namespace NotificationChannels\CmComWhatsApp\Types;

use CMText\RichContent\Messages\MediaMessage;

class RichContentMessageType extends PlainTextMessageType
{
    /*
     * @var RichContentMessageMediaSubtype|null $media_content
     */
    public $media_content = null;

    /**
     * @var RichContentMessageReplySuggestionSubtype[]|null $reply_suggestions
     */
    public $reply_suggestions = null;

    public function hasMediaContent(): bool
    {
        return !is_null($this->media_content);
    }

    public function hasReplySuggestions(): bool
    {
        return is_array($this->reply_suggestions) && count($this->reply_suggestions) > 0;
    }
}
