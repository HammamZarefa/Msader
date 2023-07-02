<?php

namespace App\ExternalProviders\CashSMM;

use App\ExternalProviders\ExternalProviderResponse;

class CreateOrder extends AbstractCashSMMOperation
{
    protected string $operationUrl = "add";
    protected string $method = "POST";

    public function setBody($order)
    {
        $this->body = [
            "service" => $order['service'],
            "link" => $order['link'],
            "quantity" => $order['quantity'] ?? 1,
            "runs" => $order['runs'] ?? '',
            "interval" => $order['interval'] ?? '',
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        $response->setReference($jsonDecode['order']);
        return $response->return();
    }

}
