<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

use CMText\Channels;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterBase;
use NotificationChannels\CmComSmsWhatsApp\Interfaces\SendableMessageInterface;
use NotificationChannels\CmComSmsWhatsApp\Types\Subtypes\TemplateMessageParameterSubtype;

/**
 * WhatsApp Message type
 */
class CmComWhatsAppMessageTemplateType extends PlainTextMessageType implements SendableMessageInterface
{

    /**
     * @var string
     */
    public $languageCode;

    /**
     * @var string
     */
    public $templateId;

    /**
     * @var string
     */
    public $namespace;

    /**
     * @var ComponentParameterBase[]
     */
    public $parameters;

    public function __construct(string $from, array $to, string $text, string $templateId, string $namespace, string $languageCode)
    {
        parent::__construct($from, $to, $text);
        $this->templateId = $templateId;
        $this->namespace = $namespace;
        $this->languageCode = $languageCode;
    }

    /**
     * @inheritDoc
     */
    public function getMessageAppChannel(): string
    {
        return Channels::WHATSAPP;
    }

    /**
     * Add a text template parameter, which will be sent to the WhatsApp template.
     * @throws \Exception
     */
    public function addTextParameter(string $name, string $value): void
    {
        $this->addParameter(new TemplateMessageParameterSubtype($name, $value, TemplateMessageParameterSubtype::TEXT));
    }

    /**
     * Add a currency template parameter, which will be sent to the WhatsApp template.
     * @throws \Exception
     */
    public function addCurrencyParameter(string $name, string $value, string $isoCode): void
    {
        $parameter = new TemplateMessageParameterSubtype($name, $value, TemplateMessageParameterSubtype::CURRENCY);
        $parameter->setCurrency($isoCode);
        $this->addParameter($parameter);
    }

    /**
     * Add a datetime template parameter, which will be sent to the WhatsApp template.
     *
     * @throws \Exception
     */
    public function addDateTimeParameter(string $name, string $value): void
    {
        $this->addParameter(new TemplateMessageParameterSubtype($name, $value, TemplateMessageParameterSubtype::DATETIME));
    }

    /**
     * Add a generic parameter, which will be sent to the WhatsApp template.
     * @throws \Exception
     */
    private function addParameter(TemplateMessageParameterSubtype $parameter) {
        if (!$this->hasParameters()) {
            $this->parameters = [];
        }
        $this->parameters[] = $parameter->toVariableValueObject();
    }

    public function hasParameters(): bool
    {
        return isset($this->parameters) && count($this->parameters) > 0;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
}
