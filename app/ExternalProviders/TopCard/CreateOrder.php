<?php

namespace App\ExternalProviders\TopCard;

use App\ExternalProviders\ExternalProviderResponse;
use Illuminate\Support\Str;

class CreateOrder extends AbstractTopCardOperation
{
    protected string $operationUrl = "newOrder";
    protected string $method = "GET";

    public function setBody($order)
    {
        $this->orderId = $order['id'] ?? '';
        $this->body = [
            "qty" => $order['quantity'] ?? 1,
            "playerID" => $order['link'],
            "order_uuid" => Str::uuid()
        ];
        $this->operationUrl = $this->operationUrl."/".$order['service']."/params";
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        if (isset($jsonDecode['data']['status']) && $jsonDecode['data']['status'] == "ERROR") {
            $response->setIsSuccess(false);
            $response->setPayload($jsonDecode);
        } else {
            $response->setIsSuccess(true);
            $response->setPayload($jsonDecode);
            $response->setOrderId($this->getOrderId());
            $response->setReference($jsonDecode['data']['order_id']);
            $response->setStatus(self::STATUS_PENDING);
        }
        return $response->return();
    }

}
