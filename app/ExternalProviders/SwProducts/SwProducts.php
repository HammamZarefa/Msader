<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\ProviderInterface;
use Facades\App\ExternalProviders\SwProducts\PlaceOrder;
use Facades\App\ExternalProviders\SwProducts\GetBalance;
use Facades\App\ExternalProviders\SwProducts\GetServices;
use Facades\App\ExternalProviders\SwProducts\GetOrderStatus;

class SwProducts implements ProviderInterface
{
    protected array $provider;
    protected array $order;


    public function getServices(): array
    {
        return GetServices::setProvider($this->provider)->send();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserBalance(): array
    {
        return GetBalance::setProvider($this->provider)->send();
    }

    public function getUserInformation(): array
    {
        // TODO: Implement getUserBalance() method.
    }

    public function placeOrder(): array
    {
        return PlaceOrder::setProvider($this->provider)->setBody($this->order)->send();
    }

    public function getOrderStatus(string $orderId, string $reference): array
    {
        return GetOrderStatus::setProvider($this->provider)
            ->setTrackId($orderId)
            ->setReference($reference)
            ->send();
    }


    public function setProvider($provider): ProviderInterface
    {
        $this->provider = $provider;
        return $this;
    }
    public function setOrder($order) : ProviderInterface
    {
        // Order Validation must be here
        $this->order = $order;
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
                    ['label' => 'production', 'value' => 'https://sw-games.net/api/']
                ]
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
        // TODO: Implement getCountries() method.
    }

    public function getSms($order_id): array
    {
        // TODO: Implement getSms() method.
    }
}
