<?php

namespace App\ExternalProviders\Lord;


use App\ExternalProviders\Lord\AbstractLordOperation;

class GetServices extends AbstractLordOperation
{
    protected string $operationUrl = 'ListProducts';
    protected string $method = 'POST';


    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode['products'] as $service) {
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
