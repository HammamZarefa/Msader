<?php

namespace App\ExternalProviders\OnlySMM;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractOnlySMMOperation
{
    protected string $operationUrl = 'balance';
    protected string $method = 'POST';

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonResponse);
        $response->setBalance($jsonResponse['balance']);
        return $response->return();
    }
}
