<?php

namespace App\ExternalProviders\XpCard;


use App\ExternalProviders\XpCard\AbstractXpCardOperation;

class GetServices extends AbstractXpCardOperation
{
    protected string $operationUrl = 'products';
    protected string $method = 'POST';


    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode['products'] as $service) {
            $response[] = [
                'service' => $service['id'],
                'name' => $service['name'],
                'rate' => $service['sale_price']
            ];
        }
        return $response;
    }
}
