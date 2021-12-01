<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types;

use CMText\Channels;
use CMText\RichContent\Messages\MediaContent;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterBase;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterImage;
use NotificationChannels\CmComSmsWhatsApp\Interfaces\SendableMessageInterface;
use NotificationChannels\CmComSmsWhatsApp\Types\Subtypes\TemplateMessageParameterSubtype;
use NotificationChannels\CmComSmsWhatsApp\Types\Subtypes\WhatsAppTemplateParameters;

/**
 * WhatsApp Message type
 */
class CmComWhatsAppMessageTemplateType extends PlainTextMessageType implements SendableMessageInterface
{

    /**
     * @var string
     */
    public string $languageCode;

    /**
     * @var string
     */
    public string $templateId;

    /**
     * @var string
     */
    public string $namespace;

    /**
     * @var WhatsAppTemplateParameters|null
     */
    public ?WhatsAppTemplateParameters $parameters;

    public function __construct(string $from, array $to, string $text, string $templateId, string $namespace, string $languageCode)
    {
        parent::__construct($from, $to, $text);
        $this->templateId = $templateId;
        $this->namespace = $namespace;
        $this->languageCode = $languageCode;
        $this->parameters = null;
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
    public function addTextBodyParameter(string $name, string $value): void
    {
        $this->addBodyParameter(new TemplateMessageParameterSubtype($name, $value, TemplateMessageParameterSubtype::TEXT));
    }

    /**
     * Add a currency template parameter, which will be sent to the WhatsApp template.
     * @throws \Exception
     */
    public function addCurrencyBodyParameter(string $name, string $value, string $isoCode): void
    {
        $parameter = new TemplateMessageParameterSubtype($name, $value, TemplateMessageParameterSubtype::CURRENCY);
        $parameter->setCurrency($isoCode);
        $this->addBodyParameter($parameter);
    }

    /**
     * Add a datetime template parameter, which will be sent to the WhatsApp template.
     *
     * @throws \Exception
     */
    public function addDateTimeBodyParameter(string $name, string $value): void
    {
        $this->addBodyParameter(new TemplateMessageParameterSubtype($name, $value, TemplateMessageParameterSubtype::DATETIME));
    }

    public function addCtaParameter(string $cta): void
    {
        $this->setUpParameters();
        if (!$this->hasCtasParameters()) {
            $this->parameters->setCtas([]);
        }
        $this->parameters->addCtaParameter($cta);
    }

    public function addHeaderImage(string $url, string $name, string $mimeType): void
    {
        $this->setUpParameters();
        $this->parameters->setHeaderImage(new ComponentParameterImage(
            new MediaContent($name, $url, $mimeType)
        ));
    }

    public function hasBodyParameters(): bool
    {
        return !is_null($this->parameters) && is_array($this->parameters->getBody()) && count($this->parameters->getBody()) > 0;
    }

    public function hasCtasParameters(): bool
    {
        return !is_null($this->parameters) && is_array($this->parameters->getCtas()) && count($this->parameters->getBody()) > 0;
    }

    public function hasHeaderImage(): bool
    {
        return !is_null($this->parameters) && !is_null($this->parameters->getHeaderImage());
    }

    public function setBodyParameters(array $parameters): void
    {
        $this->parameters->setBody($parameters);
    }

    /**
     * Add a generic parameter, which will be sent to the WhatsApp template.
     * @throws \Exception
     */
    private function addBodyParameter(TemplateMessageParameterSubtype $parameter)
    {
        $this->setUpParameters();
        if (!$this->hasBodyParameters()) {
            $this->parameters->setBody([]);
        }
        $this->parameters->addBodyParameter($parameter->toVariableValueObject());
    }

    private function setUpParameters(): void
    {
        if (is_null($this->parameters)) {
            $this->parameters = new WhatsAppTemplateParameters();
        }
    }
}
