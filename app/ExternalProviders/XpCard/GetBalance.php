<?php

namespace App\ExternalProviders\XpCard;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractXpCardOperation
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
