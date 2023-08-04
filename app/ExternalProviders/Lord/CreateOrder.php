<?php

namespace App\ExternalProviders\Lord;

use App\ExternalProviders\ExternalProviderResponse;

class CreateOrder extends AbstractLordOperation
{
    protected string $operationUrl = "RequestOrder";
    protected string $method = "POST";

    public function setBody($order)
    {
        $this->orderId = $order['id'] ?? '';
        $this->body = [
            "productId" => $order['service'],
            "playernumber" => $order['link'],
            "amount" => $order['quantity'] ?? 1,
            "playername" => $order['playername'] ?? ''
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        if (isset($jsonDecode['Code']) && $jsonDecode['Code'] == 0) {
            $response->setIsSuccess(false);
            $response->setPayload($jsonDecode);
        } else {
            $response->setIsSuccess(true);
            $response->setPayload($jsonDecode);
            $response->setOrderId($this->getOrderId());
            $response->setReference($jsonDecode['orderId']);
            $response->setStatus(self::STATUS_PENDING);
        }
        return $response->return();
    }

}
