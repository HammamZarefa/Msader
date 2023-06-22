<?php

namespace App\ExternalProviders\SmsActivate;


use App\ExternalProviders\ProviderInterface;
use Facades\App\ExternalProviders\SmsActivate\GetBalance;
use Facades\App\ExternalProviders\SmsActivate\CreateOrder;

class SmsActivate implements ProviderInterface
{
    protected array $provider;

    public function getServices(): array
    {
        return [];
    }

    public function getUserBalance(): array
    {
        return GetBalance::setProvider($this->provider)->send();
    }

    public function placeOrder(): array
    {
        return CreateOrder::setProvider($this->provider)->setBody()->send();
    }

    public function getOrderStatus(string $orderId, string $reference): array
    {
        // TODO: Implement getOrderStatus() method.
    }

    public function setProvider($provider): ProviderInterface
    {
        $this->provider = $provider;
        return $this;
    }

    public function getProviderSettings(): array
    {
        return [
            [
                'name' => 'url',
                'isRequired' => 'true',
                'type' => 'select',
                'options' => [
                    ['label' => 'production', 'value' => 'https://api.sms-activate.org/stubs/handler_api.php']
                ]
            ],
            [
                'name' => 'apikey',
                'isRequired' => 'true',
                'type' => 'text',
            ],
        ];
    }


    public function getCountries(): array
    {
        return [];
    }

    public function getSms(): array
    {
        return [];
    }
}
