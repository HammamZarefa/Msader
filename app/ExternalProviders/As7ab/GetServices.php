<?php

namespace App\ExternalProviders\As7ab;


use App\ExternalProviders\As7ab\AbstractAs7abOperation;

class GetServices extends AbstractAs7abOperation
{
    protected string $operationUrl = 'products';
    protected string $method = 'GET';
    protected $product;

    public function getOperationUrl(): string
    {
        return $this->operationUrl . '/' . $this->product;
    }

    public function setProductID($product)
    {
        $this->product = $product;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode['products'] as $service) {
            $response[] = [
                'service' => $service['denomination_id'],
                'name' => $service['product_name'],
                'rate' => $service['product_price']
            ];
        }
        return $response;
    }
}
