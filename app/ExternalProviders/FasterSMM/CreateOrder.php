<?php

namespace App\ExternalProviders\FasterSMM;

use App\ExternalProviders\ExternalProviderResponse;

class CreateOrder extends AbstractFasterSMMOperation
{
    protected string $operationUrl = "add";
    protected string $method = "POST";

    public function setBody($order)
    {
        $this->orderId = $order['id'] ?? '';
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
        if(isset($jsonDecode['error'])) {
            $response->setIsSuccess(false);
            $response->setPayload($jsonDecode);
        } else {
            $response->setIsSuccess(true);
            $response->setPayload($jsonDecode);
            $response->setOrderId($this->getOrderId());
            $response->setReference($jsonDecode['order']);
            $response->setStatus(self::STATUS_PENDING);
        }
        return $response->return();
    }

}
