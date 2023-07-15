<?php

namespace App\ExternalProviders\Nonvoip;


use App\ExternalProviders\ProviderInterface;
use Facades\App\ExternalProviders\Nonvoip\GetBalance;
use Facades\App\ExternalProviders\Nonvoip\GetSMS;
use Facades\App\ExternalProviders\Nonvoip\CreateOrder;
use Facades\App\ExternalProviders\Nonvoip\GetServices;

class Nonvoip implements ProviderInterface
{
    protected array $provider;
    protected $order;

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
      return [];
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
                    ['label' => 'production', 'value' => 'https://non-voip.com/api/reseller']
                ]
            ],
            [
                'name' => 'email',
                'isRequired' => 'true',
                'type' => 'text',
            ],
            [
                'name' => 'api_key',
                'isRequired' => 'true',
                'type' => 'text',
            ],
        ];
    }


    public function getCountries(): array
    {
        return [];
    }

    public function getSms($order_id): array
    {
        return GetSMS::setProvider($this->provider)->setBody($order_id)->send();
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
}
