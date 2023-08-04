<?php

namespace App\ExternalProviders\WDM;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractWDMOperation
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
