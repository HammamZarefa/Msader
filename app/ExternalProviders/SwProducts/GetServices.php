<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\ExternalProviderResponse;

class GetServices extends AbstractSwProductsOperation
{
    protected string $operationUrl = 'games';
    protected string $method = 'GET';

    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode['games'] as $service) {
            $response[] = [
                'service' => $service['id'],
                'name' => $service['name_ar']
            ];
        }
        return $response;
    }

}
