<?php

namespace App\ExternalProviders\As7ab;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractAs7abOperation
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
