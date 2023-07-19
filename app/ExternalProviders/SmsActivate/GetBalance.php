<?php

namespace App\ExternalProviders\SmsActivate;

use App\ExternalProviders\ExternalProviderResponse;

class GetBalance extends AbstractSmsActivateOperation
{
    protected string $operationUrl = 'getBalance';
    protected string $method = 'GET';

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $jsonDecode = (string) $jsonResponse->getBody();
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
       $response->setBalance((double)str_replace("ACCESS_BALANCE:",'',$jsonDecode));
        return $response->return();
    }
}
