<?php

namespace App\ExternalProviders\N1Panel;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractN1PanelOperation
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
