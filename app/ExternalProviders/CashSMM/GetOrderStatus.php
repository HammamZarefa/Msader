<?php

namespace App\ExternalProviders\CashSMM;

use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractCashSMMOperation
{
    protected string $operationUrl = 'status';
    protected string $method = 'POST';

    public function setBody($reference)
    {
        $this->body = [
            'order' => $reference
        ];

        return $this;
    }

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonResponse);
        $response->setOrderId($this->getOrderId());
        $response->setStatus($jsonResponse['status']);
        return $response->return();
    }
}
