<?php

namespace App\ExternalProviders\Nonvoip;

use App\ExternalProviders\ExternalProviderResponse;

class CreateOrder extends AbstractNonvoipOperation
{
    protected string $operationUrl = 'order_number';
    protected string $method = 'POST';
    protected string $orderId;

    public function setBody($order)
    {
        $this->body = [
            'service_id' => (string)$order['service']
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        $response->setReference($jsonDecode['order_id']);
        $response->setCustomField($jsonDecode['number']);
        $response->setService($jsonDecode['service']);
        return $response->return();
    }

}
