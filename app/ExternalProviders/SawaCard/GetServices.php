<?php

namespace App\ExternalProviders\SawaCard;


use App\ExternalProviders\SawaCard\AbstractSawaCardOperation;

class GetServices extends AbstractSawaCardOperation
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
