<?php

namespace NotificationChannels\CmComWhatsApp\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static('In order to send notifications via CMSWhatsApp you need to add your product key in the `cmcomwhatsapp` key of `config.services`.');
    }
}
