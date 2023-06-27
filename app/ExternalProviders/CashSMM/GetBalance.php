<?php

namespace App\ExternalProviders\CashSMM;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractCashSMMOperation
{
    protected string $operationUrl = 'balance';
    protected string $method = 'POST';

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $jsonDecode = (string) $jsonResponse->getBody();
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        return $response->return();
    }
}
