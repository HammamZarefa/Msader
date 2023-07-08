<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractSwProductsOperation
{
    protected string $operationUrl = 'users/info';
    protected string $method = 'GET';

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        return $response->return();
    }


}
