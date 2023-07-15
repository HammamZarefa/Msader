<?php

namespace App\ExternalProviders\CashSMM;


use App\ExternalProviders\ProviderInterface;
use Facades\App\ExternalProviders\CashSMM\GetBalance;
use Facades\App\ExternalProviders\CashSMM\CreateOrder;
use Facades\App\ExternalProviders\CashSMM\GetOrderStatus;
use Facades\App\ExternalProviders\CashSMM\GetServices;

class CashSMM implements ProviderInterface
{
    protected array $provider;
    protected array $order;

    public function getServices(): array
    {
        return GetServices::setProvider($this->provider)->send();
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
        return  GetOrderStatus::setProvider($this->provider)->setBody($reference)->send();
    }

    public function getCountries(): array
    {
        return [];
    }

    public function getSms($order_id): array
    {
        return [];
    }

    public function setProvider($provider): ProviderInterface
    {
        $this->provider = $provider;
        return $this;
    }

    public function setOrder($order)
    {
        $this->order =$order;
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
                    ['label' => 'production', 'value' => 'https://cashsmm.com/api/v2']
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
