<?php

namespace App\ExternalProviders\Lord;


use Facades\App\ExternalProviders\Lord\Validators\Order;
use App\ExternalProviders\ProviderInterface;
use Facades\App\ExternalProviders\Lord\GetBalance;
use Facades\App\ExternalProviders\Lord\CreateOrder;
use Facades\App\ExternalProviders\Lord\GetOrderStatus;
use Facades\App\ExternalProviders\Lord\GetServices;

class Lord implements ProviderInterface
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
        return  GetOrderStatus::setProvider($this->provider)->setOrderId($orderId)->setBody($reference)->send();
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
        $this->order = Order::validate($order);
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
                    ['label' => 'production', 'value' => 'https://lord-telecom.com/api/APIs']
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
