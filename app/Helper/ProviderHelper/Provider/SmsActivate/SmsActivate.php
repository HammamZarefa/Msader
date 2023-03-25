<?php

namespace App\Helper\ProviderHelper\Provider\SmsActivate;

use App\Helper\ProviderHelper\Provider\ProviderInterface;

class SmsActivate implements ProviderInterface
{


    public function getServices(): array
    {
        // TODO: Implement getServices() method.
    }

    public function getUserBalance(): array
    {
        return GetBalance::setProvider($this->provider);
    }

    public function placeOrder(): array
    {
        // TODO: Implement placeOrder() method.
    }

    public function getOrderStatus(string $orderId, string $reference): array
    {
        // TODO: Implement getOrderStatus() method.
    }

    public function setProvider($provider): ProviderInterface
    {
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


}
