<?php

namespace NotificationChannels\CmComSmsWhatsApp\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static('In order to send notifications via CMSWhatsApp you need to add your product key in the `cmcomsmswhatsapp` key of `config.services`.');
    }
}
