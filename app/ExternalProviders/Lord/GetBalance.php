<?php

namespace App\ExternalProviders\Lord;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractLordOperation
{
    protected string $operationUrl = 'GetBalance';
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
