<?php

namespace App\ExternalProviders\Lord;

use App\ExternalProviders\AbstractOperation;
use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractLordOperation
{
    protected string $operationUrl = 'OrderStatus';
    protected string $method = 'POST';

    public function setBody($reference)
    {
        $this->body = [
            'orderId' => $reference
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
        $response->setStatus($this->mapStatus($jsonResponse['status']));
        return $response->return();
    }
}
