<?php

namespace App\ExternalProviders\SmsActivate;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractSmsActivateOperation
{
    protected string $operationUrl = 'getBalance';
    protected string $method = 'get';

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        return $response->return();
    }
}
