<?php

namespace NotificationChannels\CmComSmsWhatsApp\Types\Subtypes;

use Carbon\Carbon;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterBase;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterCurrency;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterDatetime;
use CMText\RichContent\Templates\Whatsapp\ComponentParameterText;
use NotificationChannels\CmComSmsWhatsApp\Config\Currencies;

/**
 * When you have to specify a parameter for a template, you can use this class to specify the parameter.
 */
class TemplateMessageParameterSubtype
{

    const TEXT = 0;
    const DATETIME = 1;
    const CURRENCY = 2;

    const FORMAT_DATETIME = \DateTimeInterface::ISO8601;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $value
     */
    public $value;

    /**
     * One of 0 (TEXT), 1 (DATETIME) e 2 (CURRENCY)
     * @var int
     */
    public $parameterType;

    /**
     * Currency ISO code
     */
    public $currencyIso;

    /**
     * Build a parameter type
     *
     * @param string $name parameter name
     * @param string $value parameter value. If $parameterType is Datetime, the format is ISO8601.
     * @param int $parameterType One of 0 (TEXT), 1 (DATETIME) e 2 (CURRENCY).
     */
    public function __construct(string $name, string $value, int $parameterType)
    {
        $this->name = $name;
        $this->value = $value;
        $this->parameterType = $parameterType;
        $this->currencyIso = Currencies::DEFAULT;
    }

    /**
     * Set the currency ISO code.
     * @param string $currency_iso
     */
    public function setCurrency(string $currency_iso)
    {
        if (!isset(Currencies::LIST[$currency_iso])) {
            throw new \InvalidArgumentException('Invalid currency ISO code');
        }
        $this->currencyIso = $currency_iso;
    }

    /**
     * Returns the parameter as a ComponentParameterBase specific for the parameter type
     * @return ComponentParameterBase
     * @throws \Exception
     */
    public function toVariableValueObject(): ComponentParameterBase
    {
        switch ($this->parameterType) {
            case self::TEXT:
                return new ComponentParameterText($this->value);
            case self::DATETIME:
                return new ComponentParameterDatetime(Carbon::now()->format(self::FORMAT_DATETIME), Carbon::createFromFormat(self::FORMAT_DATETIME, $this->value));
            case self::CURRENCY:
                $currency_symbol = Currencies::LIST[$this->currencyIso]['symbol'];
                return new ComponentParameterCurrency("{$currency_symbol}0", $this->currencyIso, (int)$this->value);
            default:
                throw new \Exception("Invalid variable type");
        }
    }
}
