<?php

namespace App\ExternalProviders\SmsActivate;


use App\ExternalProviders\ProviderInterface;
use Facades\App\ExternalProviders\SmsActivate\GetBalance;
use Facades\App\ExternalProviders\SmsActivate\CreateOrder;
use Facades\App\ExternalProviders\SmsActivate\GetSMS;

class SmsActivate implements ProviderInterface
{
    protected array $provider;
    protected array $order;

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
        return CreateOrder::setProvider($this->provider)->setBody($this->order)->send();
    }

    public function getOrderStatus(string $orderId, string $reference): array
    {
        // TODO: Implement getOrderStatus() method.
    }

    public function getCountries(): array
    {
        return [];
    }

    public function getSms($order_id): array
    {
        return GetSMS::setProvider($this->provider)->setBody($order_id)->send();
    }

    public function setProvider($provider): ProviderInterface
    {
        $this->provider = $provider;
        return $this;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
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
                'name' => 'api_key',
                'isRequired' => 'true',
                'type' => 'text',
            ],
        ];
    }


}
