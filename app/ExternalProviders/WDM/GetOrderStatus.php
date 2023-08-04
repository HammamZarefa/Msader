<?php

namespace App\ExternalProviders\WDM;

use App\ExternalProviders\AbstractOperation;
use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractWDMOperation
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

    public function setOrderId($orderId): AbstractOperation
    {
        $this->orderId = $orderId;
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
