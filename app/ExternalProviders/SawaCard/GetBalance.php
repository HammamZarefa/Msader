<?php

namespace App\ExternalProviders\SawaCard;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractSawaCardOperation
{
    protected string $operationUrl = 'profile';
    protected string $method = 'GET';

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonResponse);
        $response->setBalance($jsonResponse['balance']);
        return $response->return();
    }
}
