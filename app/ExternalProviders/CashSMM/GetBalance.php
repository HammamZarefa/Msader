<?php

namespace App\ExternalProviders\CashSMM;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractCashSMMOperation
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
