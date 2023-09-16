<?php

namespace App\ExternalProviders\TopCard;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractTopCardOperation
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
