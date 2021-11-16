<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types\Subtypes;

use CMText\RichContent\Templates\Whatsapp\ComponentParameterBase;

class WhatsAppTemplateParameters
{
    /**
     * @var string[]|null
     */
    private ?array $ctas;

    /**
     * @var ComponentParameterBase[]|null
     */
    private ?array $body;

    /**
     * @param ComponentParameterBase[]|null $body
     * @param string[]|null $ctas
     */
    public function __construct(?array $body = null, ?array $ctas = null)
    {
        $this->body = $body;
        $this->ctas = $ctas;
    }

    /**
     * @return string[]|null
     */
    public function getCtas(): ?array
    {
        return $this->ctas;
    }

    /**
     * @param string[]|null $ctas
     */
    public function setCtas(?array $ctas): void
    {
        $this->ctas = $ctas;
    }

    /**
     * @return ComponentParameterBase[]|null
     */
    public function getBody(): ?array
    {
        return $this->body;
    }

    /**
     * @param ComponentParameterBase[]|null $body
     */
    public function setBody(?array $body): void
    {
        $this->body = $body;
    }
}
