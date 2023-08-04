<?php

namespace App\ExternalProviders\SpeedCard;


use App\ExternalProviders\SpeedCard\AbstractSpeedCardOperation;

class GetServices extends AbstractSpeedCardOperation
{
    protected string $operationUrl = 'products';
    protected string $method = 'GET';


    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode as $service) {
            $response[] = [
                'service' => $service['id'],
                'name' => $service['name'],
                'rate' => $service['price'],
                'min' => $service['minAmount'] ?? 1,
                'max' => $service['maxAmount'] ?? 1,
            ];
        }
        return $response;
    }
}
