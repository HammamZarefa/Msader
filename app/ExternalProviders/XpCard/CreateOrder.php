<?php

namespace App\ExternalProviders\XpCard;

use App\ExternalProviders\ExternalProviderResponse;

class CreateOrder extends AbstractXpCardOperation
{
    protected string $operationUrl = "create-order";
    protected string $method = "POST";

    public function setBody($order)
    {
        $this->orderId = $order['id'] ?? '';
        $this->body = [
            "product_id" => $order['service'],
            "alt" => $order['link'],
            "quantity" => $order['quantity'] ?? 1,
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        if (isset($jsonDecode['result']) && $jsonDecode['result'] != 'success') {
            $response->setIsSuccess(false);
            $response->setPayload($jsonDecode);
        } else {
            $response->setIsSuccess(true);
            $response->setPayload($jsonDecode);
            $response->setOrderId($this->getOrderId());
            $response->setReference($jsonDecode['order_id']);
            $response->setStatus(self::STATUS_PENDING);
        }
        return $response->return();
    }

}
