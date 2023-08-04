<?php

namespace App\ExternalProviders\As7ab;


use App\ExternalProviders\As7ab\AbstractAs7abOperation;

class GetProducts extends AbstractAs7abOperation
{
    protected string $operationUrl = 'products';
    protected string $method = 'GET';
    protected $product;


    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode['products'] as $service) {
            $response[] = [
                'service' => $service['id'],
                'name' => $service['name'],
            ];
        }
        return $response;
    }
}
