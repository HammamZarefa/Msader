<?php

namespace App\ExternalProviders\As7ab;

use App\ExternalProviders\ExternalProviderResponse;

class CreateOrder extends AbstractAs7abOperation
{
    protected string $operationUrl = "create-order";
    protected string $method = "POST";

    public function setBody($order)
    {
        $this->orderId = $order['id'] ?? '';
        $this->body = [
            "items" => [
                "product_id" => $order['service'],
                "quantity" => $order['quantity'] ?? 1,
            ],
            "args" => ["playerid" => $order['link'],],
            'orderToken' => $this->orderId
        ];
        if (isset($order->amount))
            $this->body['items']['amount'] = $order->amount;
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
            $response->setReference($jsonDecode['orderid']);
            $response->setStatus(self::STATUS_PENDING);
        }
        return $response->return();
    }

}
