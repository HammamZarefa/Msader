<?php

namespace App\ExternalProviders;

interface ProviderInterface
{
    public function getServices(): array;

    public function getCountries(): array;

    public function getSms(): array;

    public function getUserBalance(): array;

    public function placeOrder(): array;

    public function getOrderStatus(string $orderId, string $reference): array;

    public function getProviderSettings(): array;

    public function setProvider($provider): ProviderInterface;

}
