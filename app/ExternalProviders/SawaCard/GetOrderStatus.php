<?php

namespace App\ExternalProviders\SawaCard;

use App\ExternalProviders\AbstractOperation;
use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractSawaCardOperation
{
    protected string $operationUrl = 'check';
    protected string $method = 'GET';

    public function setBody($reference)
    {
        $this->body = [
            'orders' => "[{$reference}]"
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
