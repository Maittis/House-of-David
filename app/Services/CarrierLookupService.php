<?php

namespace App\Services;

use InvalidArgumentException;

class CarrierLookupService
{
    protected array $carrierGateways;

    public function __construct(?array $carrierGateways = null)
    {
        $this->carrierGateways = $carrierGateways ?? [
            // Zambia carriers
            'airtel' => '@airtel-sms.com',
            'mtn' => '@mtn-sms.com',
            'zamtel' => '@zamtel-sms.com',

            // US carriers
            'att' => '@txt.att.net',
            'verizon' => '@vtext.com',
            'tmobile' => '@tmomail.net',
            'sprint' => '@messaging.sprintpcs.com'
        ];
    }

    public function getGateway(string $phoneNumber, string $carrier): string
    {
        $carrier = strtolower($carrier);

        if (!isset($this->carrierGateways[$carrier])) {
            throw new InvalidArgumentException("Unsupported carrier: $carrier");
        }

        $cleanedNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (empty($cleanedNumber)) {
            throw new InvalidArgumentException("Invalid phone number format");
        }

        return $cleanedNumber . $this->carrierGateways[$carrier];
    }

    public function getSupportedCarriers(): array
    {
        return array_keys($this->carrierGateways);
    }

    public function isCarrierSupported(string $carrier): bool
    {
        return isset($this->carrierGateways[strtolower($carrier)]);
    }
}
